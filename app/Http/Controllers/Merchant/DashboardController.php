<?php
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\AirtimeTransaction;
use App\Models\dataTransactions;
use App\Models\EducationTransaction;
use App\Models\EletricityTransaction;
use App\Models\FundTransaction;
use App\Models\InsuranceTransaction;
use App\Models\Merchant;
use App\Models\MerchantPreferences;
use App\Models\MerchantUser;
use App\Models\Notification;
use App\Models\Percentage;
use App\Models\Setting;
use App\Models\TvTransactions;
use App\Models\User;
use App\Models\UserMessage;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user             = Auth::guard('merchant')->user();                                              // Get the currently authenticated user
        $userCount        = User::count();                                                                // Get the total number of users
        $totalUserBalance = MerchantUser::where('merchant_id', $user->id)->get()->sum('account_balance'); // Get the total balance of all users

                                                    // Check the action query parameter
        $action    = $request->query('action', ''); // Default to empty string if not set
        $hideModal = ($action === 'hideModal');
        $showModal = ($action === 'showModal');
        // $notifications = Notification::where('username', $user->username)->get();

        // Get total credited amount from FundTransaction

        $totalCreditedAmount = WalletTransaction::where('wallet_owner_id', $user->id)->where('wallet_owner_type', Merchant::class)->sum('amount');

        // Get total debited amounts from each transaction type (all users)
        $totalAirtimeDebited     = AirtimeTransaction::sum('amount');
        $totalDataDebited        = DataTransactions::sum('amount');
        $totalEducationDebited   = EducationTransaction::sum('amount');
        $totalElectricityDebited = EletricityTransaction::sum('amount');
        $totalInsuranceDebited   = InsuranceTransaction::sum('amount');
        $totalTvDebited          = TvTransactions::sum('amount');

        // Calculate total debited amount from all transactions combined
        $totalDebitedAmount = $totalAirtimeDebited + $totalDataDebited + $totalEducationDebited +
            $totalElectricityDebited + $totalInsuranceDebited + $totalTvDebited;

        $totalUserBalance = $user->wallet->balance ?? 0; // Get the user's wallet balance

        return view('merchant-layout.dashboard.index', [
            'showModal' => $showModal,
            // 'notifications' => $notifications,
            'hideModal' => $hideModal,
        ], compact('user', 'userCount', 'totalUserBalance', 'totalCreditedAmount', 'totalDebitedAmount', 'totalUserBalance'));
    }

    public function getMerchantUsers($merchantId)
    {
        $merchant = Merchant::where('id', $merchantId)->first();
        $users    = $merchant->users()->get();
        return view('merchant-layout.users.all-users')->with(compact('users'));
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
        $fundAccount = FundTransaction::where('identity', 'like', '%Manual Funding%')
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
        $user = User::find($userId);
        return view('merchant-layout.user.addFund', compact('user'));
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
            'amount' => 'required|numeric', // Ensure the amount is numeric
        ]);

        $user          = User::find($id);
        $configuration = Setting::first();
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $amount = $request->input('amount');
        // $user->account_balance += $amount;

        if ($user->save()) {
            // Record the transaction in the fund_transactions table
            $transaction = FundTransaction::create([
                'user_id'     => $user->id,
                'username'    => $user->username,
                'tel'         => $user->tel,
                'amount'      => $amount,
                'reference'   => 'TXN-' . now()->format('YmdHis') . Str::random(5),
                'identity'    => 'Manual Funding',
                'status'      => 'Success',
                'prev_bal'    => $user->account_balance,
                'current_bal' => $user->account_balance += $amount,
            ]);

            // Check if this is the first funding for the user
            $isFirstFunding = FundTransaction::where('user_id', $user->user_id)->count() === 1;

            // Handle referral bonus logic for the first funding
            if ($isFirstFunding && ! empty($user->refferal_user)) {
                $referrer = User::where('user_id', $user->refferal_user)->first();

                if ($referrer) {
                    $referralBonus = ($amount * $configuration->bonus) / 100; // Calculate 5% of the original amount
                    $referrer->increment('account_balance', $referralBonus);
                    $referrer->increment('refferal_bonus', $referralBonus);
                }
            }
            return response()->json(['message' => 'User update successful'], 200);
        } else {
            return response()->json(['message' => 'User update failed'], 500);
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
        $airtimes = Percentage::where('service', [
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
        $airtimes = Percentage::where('service', [
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

        $data_transaction = dataTransactions::all();
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
        $airtimes = Percentage::where('service', [
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

        $eletricity_transaction = EletricityTransaction::all();
        return view('merchant-layout.electricity', [
            'airtimes'               => $airtimes,
            'eletricity_transaction' => $eletricity_transaction,
        ]);
    }

    public function merchantTv()
    {

        // Retrieve only the percentages for specific services
        $airtimes = Percentage::where('service', [
            'Gotv_Payment',
            'Dstv_Payment',
            'Startime_Payment',
            'Showmax_Payment',
        ])->get();

        $tv_transaction = TvTransactions::orderBy('created_at', 'desc')->get();
        return view('merchant-layout.cableTv', [
            'airtimes'       => $airtimes,
            'tv_transaction' => $tv_transaction,
        ]);
    }

    public function merchantEducation()
    {
        // Retrieve only the percentages for specific services
        $airtimes = Percentage::where('service', [
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
        $airtimes = Percentage::where('service', [
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
        // Fetch and merge transactions
        $airtimeTransactions     = AirtimeTransaction::orderBy('created_at', 'desc')->get();
        $dataTransactions        = DataTransactions::orderBy('created_at', 'desc')->get();
        $educationTransactions   = EducationTransaction::orderBy('created_at', 'desc')->get();
        $electricityTransactions = EletricityTransaction::orderBy('created_at', 'desc')->get();
        $fundTransactions        = FundTransaction::orderBy('created_at', 'desc')->get();
        $insuranceTransactions   = InsuranceTransaction::orderBy('created_at', 'desc')->get();
        $tvTransactions          = TvTransactions::orderBy('created_at', 'desc')->get();

        // Combine and sort all transactions
        $allTransactions = collect()
            ->merge($airtimeTransactions)
            ->merge($dataTransactions)
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
        dd('' . $auth->id . '');
        $settings = MerchantPreferences::where('merchant_id', $auth->id)->first();

        // If no value is found, fallback to a default (e.g., 1.7)
        $monnifyFee = $settings->monnify_percent;

        return response()->json([
            'fee' => $monnifyFee,
        ]);
    }

}
