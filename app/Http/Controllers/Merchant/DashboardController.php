<?php
namespace App\Http\Controllers\Merchant;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Setting;
use App\Models\Merchant;
use App\Models\Percentage;
use App\Models\Transaction;
use App\Models\UserMessage;
use App\Models\MerchantUser;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\TvTransaction;
use App\Models\DataTransaction;
use App\Models\FundTransaction;
use App\Models\WalletTransaction;
use App\Models\AirtimeTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\MerchantPreferences;
use App\Http\Controllers\Controller;
use App\Models\EducationTransaction;
use App\Models\InsuranceTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ElectricityTransaction;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('merchant')->user();

        // Get users associated with this merchant
        $merchantUsers = MerchantUser::where('merchant_id', $user->id)->get();

        $userCount        = $merchantUsers->count();
        $totalUserBalance = $merchantUsers->pluck('user_id')->map(function ($userId) {
            return User::find($userId)->wallet->balance ?? 0;
        })->sum();

        // Check the action query parameter
        $action    = $request->query('action', '');
        $hideModal = ($action === 'hideModal');
        $showModal = ($action === 'showModal');

        // Get merchant's user IDs
        $merchantUserIds = $merchantUsers->pluck('user_id')->toArray();

        // Get total credited amount for all merchant users
        $totalCreditedAmount = WalletTransaction::whereIn('wallet_owner_id', $merchantUserIds)
            ->where('wallet_owner_type', User::class)
            ->where('type', 'credit')
            ->sum('amount');

        // Get total debited amounts from each transaction type
        $totalAirtimeDebited     = AirtimeTransaction::whereIn('user_id', $merchantUserIds)->sum('amount');
        $totalDataDebited        = DataTransaction::whereIn('user_id', $merchantUserIds)->sum('amount');
        $totalEducationDebited   = EducationTransaction::whereIn('user_id', $merchantUserIds)->sum('amount');
        $totalElectricityDebited = ElectricityTransaction::whereIn('user_id', $merchantUserIds)->sum('amount');
        $totalInsuranceDebited   = InsuranceTransaction::whereIn('user_id', $merchantUserIds)->sum('amount');
        $totalTvDebited          = TvTransaction::whereIn('user_id', $merchantUserIds)->sum('amount');

        // Calculate total debited amount
        $totalDebitedAmount = $totalAirtimeDebited + $totalDataDebited + $totalEducationDebited +
            $totalElectricityDebited + $totalInsuranceDebited + $totalTvDebited;

        // Get transactions by service type for the pie chart
        $serviceTransactions = [
            'Airtime'     => $totalAirtimeDebited,
            'Data'        => $totalDataDebited,
            'Education'   => $totalEducationDebited,
            'Electricity' => $totalElectricityDebited,
            'Insurance'   => $totalInsuranceDebited,
            'TV'          => $totalTvDebited,
        ];

        // Get last 6 months transactions for the graph
        $last6Months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month             = now()->subMonths($i);
            $monthTransactions = Transaction::whereIn('transactable_id', $merchantUserIds)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            $last6Months->push([
                'month'  => $month->format('M'),
                'amount' => $monthTransactions,
            ]);
        }

        // Get recent transactions
        $recentTransactions = Transaction::whereIn('transactable_id', $merchantUserIds)

            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get the merchant's wallet balance
        $merchantBalance = Wallet::where('owner_type', Merchant::class)
            ->where('owner_id', $user->id)
            ->value('balance');

        return view('merchant-layout.dashboard.index', [
            'showModal'           => $showModal,
            'hideModal'           => $hideModal,
            'user'                => $user,
            'userCount'           => $userCount,
            'totalUserBalance'    => $totalUserBalance,
            'totalCreditedAmount' => $totalCreditedAmount,
            'totalDebitedAmount'  => $totalDebitedAmount,
            'merchantBalance'     => $merchantBalance,
            'serviceTransactions' => $serviceTransactions,
            'last6Months'         => $last6Months,
            'recentTransactions'  => $recentTransactions,
        ]);
    }

    public function getMerchantUsers($merchantId)
    {
        $merchant = Merchant::where('id', $merchantId)->first();
        $users    = $merchant->users()->get();

        // Get user statistics
        $totalUsers    = $users->count();
        $activeUsers   = $users->where('cal', 1)->count();
        $inactiveUsers = $users->where('cal', 0)->count();
        $totalBalance  = Wallet::where('owner_type', User::class)
            ->whereIn('owner_id', $users->pluck('id'))
            ->sum('balance');

        // Get new users this month
        $newUsersThisMonth = $users->filter(function ($user) {
            return $user->created_at->isCurrentMonth();
        })->count();

        // Get top users by balance
        $topUsers = Wallet::where('owner_type', User::class)
            ->whereIn('owner_id', $users->pluck('id'))
            ->orderByDesc('balance')
            ->take(5)
            ->get();

        // Get recent transactions for all users
        $recentTransactions = Transaction::whereIn('transactable_id', $users->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('merchant-layout.users.all-users', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalBalance',
            'newUsersThisMonth',
            'topUsers',
            'recentTransactions'
        ));
    }

    public function editUser($id)
    {
        // Fetch the user by ID and pass it to the view
        $user = User::find($id);
        return view('merchant-layout.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email'    => 'required|email|unique:users,email,' . $id,
        ]);

        $user           = User::find($id);
        $user->name     = $request->input('fullname');
        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->save();

        // Check if the users was successful
        if ($user->save()) {

            return response()->json(['message' => 'User update successful']);
        } else {
            // Return an error response
            return response()->json(['message' => 'User update failed']);
        }
    }

    public function deactivate($id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->route('manage')->with('error', 'User not found');
        }

        $user->cal = 0;

        if ($user->save()) {
            return redirect()->route('manage')->with('success', 'User deactivated successfully');
        } else {
            return redirect()->route('manage')->with('error', 'Failed to deactivate user');
        }
    }

    public function activate($id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->route('manage')->with('error', 'User not found');
        }

        $user->cal = 1;

        if ($user->save()) {
            return redirect()->route('manage')->with('success', 'User activated successfully');
        } else {
            return redirect()->route('manage')->with('error', 'Failed to activate user');
        }
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->route('manage')->with('error', 'User not found');
        }

        if ($user->delete()) {
            return redirect()->route('manage')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('manage')->with('error', 'Failed to delete user');
        }
    }

    public function createUser(Request $request, $merchantId)
    {
        // Logic to create a new user for the merchant
        // This could involve showing a form or processing a request
        return view('merchant-layout.users.create', ['merchantId' => $merchantId]);
    }
    /**
     * Show the form for crediting a user's account.
     *
     * @return \Illuminate\View\View
     */
    public function creditUserAccount()
    {
        $merchant    = Auth::guard('merchant')->user();
        $users       = $merchant->users()->get();
        $fundAccount = WalletTransaction::where('provider', 'like', '%Manual Funding%')
            ->orderBy('created_at', 'desc')
            ->get();

        // Logic to credit a user's account
        return view('merchant-layout.users.credit-account')->with(compact('users', 'fundAccount'));
    }

    /**
     * Show the form for adding funds to a user's account.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function addFund($userId)
    {
        $user            = User::find($userId);
        $merchantBalance = Wallet::where('owner_type', Merchant::class)
            ->where('owner_id', $user->id)
            ->value('balance');
        return view('merchant-layout.addFund', compact('user', 'merchantBalance'));
    }

    /**
     * Show the form for approving funds for a user.
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function approveFund($userId)
    {
        $funding = FundTransaction::find($userId);
        return view('merchant-layout.user.approveFund', compact('funding'));
    }

    public function fundUser(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user     = User::findOrFail($id);
        $amount   = $request->input('amount');
        $merchant = Auth::user();

        // Get merchant's wallet
        $merchantWallet = Wallet::where('owner_id', $merchant->id)
            ->where('owner_type', Merchant::class)
            ->first();

        if (! $merchantWallet || $merchantWallet->balance < $amount) {
            return response()->json([
                'message'         => 'Insufficient merchant balance',
                'merchantBalance' => $merchantWallet ? $merchantWallet->balance : 0,
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Deduct from merchant's wallet
            $merchantWallet->decrement('balance', $amount);

            $transaction = Transaction::initialize([
                'transactable_type' => Merchant::class,
                'transactable_id'   => $user->id,

                'amount'            => $amount['amount'],
                'type'              => $request->type,
                'kind'              => 'debit',
                'payload'           => [
                    'Merchant Name'   => $user->name,
                    'Merchant domain' => $user->domain, // Initially pending until confirmed
                ],
                'provider'          => 'Manual Funding',
            ]);

            // Create merchant wallet transaction
            WalletTransaction::create([
                'wallet_owner_id'   => $merchant->id,
                'wallet_owner_type' => Merchant::class,
                'wallet_id'         => $merchantWallet->id,
                'transaction_id'    => $transaction->id,
                'type'              => 'debit',
                'amount'            => $amount,
                'status'            => 'pending',
                'provider'          => 'Manual Funding',
            ]);

            // Add to user's balance
            $user->wallet->increment('balance', $amount);

            DB::commit();
            return response()->json([
                'message'         => 'Fund transfer successful',
                'transaction'     => $transaction,
                'merchantBalance' => $merchantWallet->balance,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Fund transfer failed: ' . $e->getMessage()], 500);
        }
    }

    public function approveFundUser(Request $request, $id)
    {
        // Validate the request to ensure 'amount' is numeric and required
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        // Find the FundTransaction by ID
        $funding = FundTransaction::find($id);

        // Check if the funding transaction exists
        if (! $funding) {
            return response()->json(['message' => 'Funding transaction not found'], 404);
        }

        // Retrieve the username from the funding transaction
        $userfund = $funding->username;

        // Find the user based on the username
        $user = User::where('username', $userfund)->first();

        // Check if the user exists
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the funding transaction status from 'pending' to 'SUCCESS'
        $funding->status = 'SUCCESS';
        $funding->save(); // Save the updated status

        // Retrieve the amount from the request input
        $amount = $request->input('amount');

        // Add the amount to the user's account balance
        $user->account_balance += $amount;

        // Save the updated user balance
        if ($user->save()) {
            return response()->json(['message' => 'User update successful'], 200);
        } else {
            return response()->json(['message' => 'User update failed'], 500);
        }
    }

    public function merchantAirtime()
    {
        // Retrieve all airtime transactions
        $airtime_transaction = AirtimeTransaction::orderBy('created_at', 'desc')->get();

        // Retrieve only the percentages for specific services
        $airtimes = Percentage::whereIn('service', [
            'MTN_Airtime_VTU',
            'Airtel_Airtime_VTU',
            'GLO_Airtime_VTU',
            '9mobile_Airtime_VTU',
        ])->get();

        return view('merchant-layout.airtime', [
            'airtimes'            => $airtimes,
            'airtime_transaction' => $airtime_transaction,
        ]);
    }

    /**
     * Show the data transactions for the admin.
     *
     * @return \Illuminate\View\View
     */
    public function merchantData()
    {

        // Retrieve all airtime transactions
        $airtime_transaction = AirtimeTransaction::orderBy('created_at', 'desc')->get();

        // Retrieve only the percentages for specific services
        $airtimes = Percentage::whereIn('service', [
            'MTN_SME_Data',
            'MTN_SME2_Data',
            'MTN_GIFTING_Data',
            'MTN_CORPORATE_GIFTING_Data',
            'Airtel_GIFTING_Data',
            'Airtel_CORPORATE_GIFTING_Data',
            'GLO_GIFTING_Data',
            'GLO_CORPORATE_GIFTING_Data',
            '9mobile_GIFTING_Data',
            '9mobile_CORPORATE_GIFTING_Data',
        ])->get();

        $data_transaction = DataTransaction::all();
        return view('merchant-layout.data', [
            'airtimes'         => $airtimes,
            'data_transaction' => $data_transaction,
        ]);
    }

    public function merchantElectricity()
    {
        // Retrieve all airtime transactions
        $airtime_transaction = AirtimeTransaction::orderBy('created_at', 'desc')->get();
        // Retrieve only the percentages for specific services
        $airtimes = Percentage::whereIn('service', [
            'Aba_Electric_Payment_-_ABEDC',
            'Abuja_Electricity_Distribution_Company_-_AEDC',
            'Benin_Electricity_-_BEDC',
            'Eko_Electric_Payment_-_EKEDC',
            'Enugu_Electric_-_EEDC',
            'IBEDC_-_Ibadan_Electricity_Distribution_Company',
            'Ikeja_Electric_Payment_-_IKEDC',
            'Jos_Electric_-_JED',
            'Kaduna_Electric_-_KAEDCO',
            'KEDCO_-_Kano_Electric',
            'PHED_-_Port_Harcourt_Electric',
            'Yola_Electric_Disco_Payment_-_YEDC',
        ])->get();

        $eletricity_transaction = ElectricityTransaction::all();
        return view('merchant-layout.electricity', [
            'airtimes'               => $airtimes,
            'eletricity_transaction' => $eletricity_transaction,
        ]);
    }

    public function merchantTv()
    {

        // Retrieve only the percentages for specific services
        $airtimes = Percentage::whereIn('service', [
            'Gotv_Payment',
            'Dstv_Payment',
            'Startime_Payment',
            'Showmax_Payment',
        ])->get();

        $tv_transaction = TvTransaction::orderBy('created_at', 'desc')->get();
        return view('merchant-layout.cableTv', [
            'airtimes'       => $airtimes,
            'tv_transaction' => $tv_transaction,
        ]);
    }

    public function merchantEducation()
    {
        // Retrieve only the percentages for specific services
        $airtimes = Percentage::whereIn('service', [
            'WAEC_Result_Checker_PIN',
            'WAEC_Registration_PIN',

        ])->get();

        $education_transaction = EducationTransaction::orderBy('created_at', 'desc')->get();
        return view('merchant-layout.education', [
            'airtimes'              => $airtimes,
            'education_transaction' => $education_transaction,
        ]);
    }

    public function merchantInsurance()
    {
        // Retrieve only the percentages for specific services
        $airtimes = Percentage::whereIn('service', [
            'Personal_Accident_Insurance',
            'Third_Party_Motor_Insurance_-_Universal_Insurance',

        ])->get();

        $insurance_transaction = InsuranceTransaction::all();
        return view('merchant-layout.insurance', [
            'airtimes'              => $airtimes,
            'insurance_transaction' => $insurance_transaction,
        ]);
    }

    public function message()
    {
        $message_user = User::orderBy('created_at', 'desc')->get();
        return view('merchant-layout.message', [
            'message_user' => $message_user,
        ]);
    }

    public function notification()
    {
        // Fetch all notifications/messages from the database
        $notifications = UserMessage::orderBy('created_at', 'desc')->get();

        return view('merchant-layout.notification', compact('notifications'));
    }

    public function marchant()
    {
        // Retrieve all users with role 1, ordered by created_at in descending order
        $users = User::where('role', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass the user data to the view
        return view('merchant-layout.viewMarchant', ['users' => $users]);
    }

    public function site_setting()
    {
        $settings = Setting::first();
        $user     = Auth::user();
        $target   = storage_path('app/public');
        $link     = public_path('storage');

        // Check if the symbolic link already exists
        if (! file_exists($link)) {
            symlink($target, $link);

        }

        return view('merchant-layout.site-setting', compact('settings', 'user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('merchant-layout.editUser', [
            'user' => $user,
        ]);
    }

    public function walletSummaryMerchant()
    {
        $merchant = Auth::guard('merchant')->user();

        $mercchantUserIDs = MerchantUser::where('merchant_id', $merchant->id)
            ->pluck('user_id')
            ->toArray();
        // Fetch and merge transactions
        $airtimeTransactions     = AirtimeTransaction::whereIn('user_id', $mercchantUserIDs)->orderBy('created_at', 'desc')->get();
        $DataTransaction         = DataTransaction::whereIn('user_id', $mercchantUserIDs)->orderBy('created_at', 'desc')->get();
        $educationTransactions   = EducationTransaction::whereIn('user_id', $mercchantUserIDs)->orderBy('created_at', 'desc')->get();
        $electricityTransactions = ElectricityTransaction::whereIn('user_id', $mercchantUserIDs)->orderBy('created_at', 'desc')->get();

        $fundTransactions        = WalletTransaction::whereIn('wallet_owner_id', $mercchantUserIDs)
        ->where('wallet_owner_type', User::class)
        ->orderBy('created_at', 'desc')->get();

        $insuranceTransactions   = InsuranceTransaction::whereIn('user_id', $mercchantUserIDs)->orderBy('created_at', 'desc')->get();
        $tvTransactions          = TvTransaction::whereIn('user_id', $mercchantUserIDs)->orderBy('created_at', 'desc')->get();

        // Combine and sort all transactions
        $allTransactions = collect()
            ->merge($airtimeTransactions)
            ->merge($DataTransaction)
            ->merge($educationTransactions)
            ->merge($electricityTransactions)
            ->merge($fundTransactions)
            ->merge($insuranceTransactions)
            ->merge($tvTransactions)
            ->sortByDesc('created_at');

        return view('merchant-layout.wallet', compact('allTransactions'));
    }

    public function messageUser(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (! $user) {
            // Redirect back with an error message if the user is not found
            return redirect()->back()->with('error', 'User not found.');
        }

        // Pass the user data to the view
        return view('merchant-layout.message_user', compact('user'));
    }
    public function add_account()
    {
        return view('merchant-layout.add_account');
    }

    public function addCharge($id)
    {
        $airtimes = Percentage::find($id);
        return view('merchant-layout.addChargeAirtime', compact('airtimes'));
    }

    public function getMonnifyFee()
    {
        // Retrieve the monnify_percent from the Setting model
        $auth = Auth::guard('merchant')->user();
        $settings = MerchantPreferences::where('merchant_id', $auth->id)->first();

        // If no value is found, fallback to a default (e.g., 1.7)
        $monnifyFee = $settings->monnify_percent;

        return response()->json([
            'fee' => $monnifyFee,
        ]);
    }

    public function updateSetting(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate(array_merge([
            'site_name'                 => 'required|string|max:255',
            'site_logo'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'api_key'                   => 'required|string',
            'secret_key'                => 'required|string',
            'site_token'                => 'required|string',
            'monnify_api_key'           => 'required|string',
            'monnify_contract_code'     => 'required|string',
            'header_color'              => 'required|string',
            'template_color'            => 'required|string',
            'test_color'                => 'required|string',
            'site_bank_name'            => 'required|string',
            'site_bank_account_name'    => 'required|string',
            'site_bank_account_account' => 'required|string',
            'site_bank_comment'         => 'required|string',
            'whatsapp_number'           => 'required|string',
            'welcome_message'           => 'required|string',
            'email'                     => 'required|string',
            'monnify_percent'           => 'required|string',
            'bonus'                     => 'required|string',
            'company_phone'             => 'required|string',
            'company_address'           => 'required|string',
            'company_email'             => 'required|string',
        ], $user->role == 0 ? [
            'airtime_api_url'                     => 'required|url',
            'transaction_api_url'                 => 'required|url',
            'data_network_api_url'                => 'required|url',
            'data_api_url'                        => 'required|url',
            'data_mtn'                            => 'required|url',
            'data_airtime'                        => 'required|url',
            'electricity_pay_api_url'             => 'required|url',
            'electricity_verify_api_url'          => 'required|url',
            'tv_bouquet_api_url'                  => 'required|url',
            'tv_billcode_api_url'                 => 'required|url',
            'education_waec_registration_api_url' => 'required|url',
            'education_waec_api_url'              => 'required|url',
            'education_jamb_api_url'              => 'required|url',
            'education_check_result_api_url'      => 'required|url',
            'education_jamb_verify_api_url'       => 'required|url',
            'insurance_health_insurance_api_url'  => 'required|url',
            'insurance_personal_accident_api_url' => 'required|url',
            'insurance_ui_insure_api_url'         => 'required|url',
            'insurance_state_api_url'             => 'required|url',
            'insurance_color_api_url'             => 'required|url',
            'insurance_brand_api_url'             => 'required|url',
            'insurance_engine_capacity_api_url'   => 'required|url',
        ] : []));

        $settings = Setting::first();

        if ($request->hasFile('site_logo')) {
            if ($settings->site_logo) {
                Storage::disk('public')->delete($settings->site_logo);
            }
            $settings->site_logo = $request->file('site_logo')->store('logos', 'public');
        }

        // Mass assign validated data (without 'site_logo')
        $settings->fill(collect($validatedData)->except('site_logo')->all());

        // Save settings
        if ($settings->save()) {
            return redirect()->route('merchant.site_setting')->with('success', 'Settings updated successfully.');
        }

        return redirect()->route('merchant.site_setting')->with('error', 'Failed to update settings.');
    }

    public function transactions()
    {
        $merchant = Auth::guard('merchant')->user();

        $merchantUserIds = MerchantUser::where('merchant_id', $merchant->id)
            ->pluck('user_id')
            ->toArray();

        $airtimeTransactions = AirtimeTransaction::whereIn('user_id', $merchantUserIds)
            ->latest()
            ->get();

        $dataTransactions = DataTransaction::whereIn('user_id', $merchantUserIds)
            ->latest()
            ->get();

        $electricityTransactions = ElectricityTransaction::whereIn('user_id', $merchantUserIds)
            ->latest()
            ->get();

        $tvTransactions = TvTransaction::whereIn('user_id', $merchantUserIds)
            ->latest()
            ->get();

        $educationTransactions = EducationTransaction::whereIn('user_id', $merchantUserIds)
            ->latest()
            ->get();

        $insuranceTransactions = InsuranceTransaction::whereIn('user_id', $merchantUserIds)
            ->latest()
            ->get();

        $walletTransactions = WalletTransaction::whereIn('wallet_owner_id', $merchantUserIds)->with('owner')
            ->where('wallet_owner_type', User::class)
            ->latest()
            ->get();

        return view('merchant-layout.transactions', compact(
            'airtimeTransactions',
            'dataTransactions',
            'electricityTransactions',
            'tvTransactions',
            'educationTransactions',
            'insuranceTransactions',
            'walletTransactions'
        ));
    }

    /**
     * Update the merchant's profile.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
      public function updateProfile(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'tel'      => 'required|string|max:15',
            'address'  => 'required|string',
            'password' => 'nullable|confirmed|min:6',
            'upgrade'  => 'nullable|integer',
        ]);

        $user = User::findOrFail($id);
        $isUpgradedToTopUser = false;

        if (isset($validatedData['upgrade'])) {
            // Reset all earners to 0 initially
            $user->smart_earners   = 0;
            $user->topuser_earners = 0;
            $user->api_earners     = 0;

            // Set the specific earner field based on upgrade value
            switch ($validatedData['upgrade']) {
                case 1:
                    $user->smart_earners = 1;
                    break;
                case 2:
                    $user->topuser_earners = 1;
                    $isUpgradedToTopUser   = true; // Mark as upgraded to topuser
                    break;
                case 3:
                    $user->api_earners = 1;
                    break;
                default:
                    // Handle unexpected values if necessary
                    break;
            }
        }

        // Update basic user information
        $user->name    = $validatedData['name'];
        $user->tel     = $validatedData['tel'];
        $user->address = $validatedData['address'];

        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Check if the user was referred and upgraded to topuser
        if ($isUpgradedToTopUser && ! empty($user->refferal_user)) {
            // Find the referrer
            $referrer = User::where('username', $user->refferal_user)->first();

            if ($referrer) {
                // Add 500 to the referrer's balance
                $referrer->wallet->increment('balance', 500);
                $referrer->increment('refferal_bonus', 500);
            }
        }

        // Save the user
        $user->save();

        // Redirect or return response
        return redirect()->route('merchant.edit.user', ['id' => $user->id])
            ->with('success', 'User updated successfully.');
    }

     public function addChargeAirtimeUser(Request $request, $id)
    {
        // Validate the inputs
        $request->validate([
            'smart_earners' => 'required|string',
            'top_users'     => 'required|string',
            'api_percent'   => 'required|string',
        ]);

        // Retrieve the validated inputs
        $smartEarners = $request->input('smart_earners');
        $topUsers     = $request->input('top_users');
        $apiPercent   = $request->input('api_percent');

        // Find the airtime record with the specified ID
        $airtime = Percentage::find($id);

        // Check if airtime record exists
        if (! $airtime) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Update the percentage fields with the given values
        $airtime->smart_earners_percent   = $smartEarners;
        $airtime->topuser_earners_percent = $topUsers;
        $airtime->api_earners_percent     = $apiPercent;

        // Save the changes and handle the response
        try {
            $airtime->save();
            return response()->json(['message' => 'Charge updated successfully']);
        } catch (\Exception $e) {
            // Log the exception if needed
            Log::error('Failed to update charge: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update charge'], 500);
        }
    }

}
