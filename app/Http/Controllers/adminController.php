<?php
namespace App\Http\Controllers;

use App\Models\AirtimeTransaction;
use App\Models\dataTransactions;
use App\Models\EducationTransaction;
use App\Models\EletricityTransaction;
use App\Models\FundTransaction;
use App\Models\InsuranceTransaction;
use App\Models\merchants;
use App\Models\Notification;
use App\Models\percentage;
use App\Models\Referral;
use App\Models\Setting;
use App\Models\TvTransactions;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class adminController extends Controller
{
    public function dashboard()
    {
        $user             = Auth::user();                 // Get the currently authenticated user
        $userCount        = User::count();                // Get the total number of users
        $totalUserBalance = User::sum('account_balance'); // Get the total balance of all users

        // Get total credited amount from FundTransaction
        $totalCreditedAmount = FundTransaction::sum('amount');

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

        // Fetch configuration (like API token) from the settings table
        $configuration = Setting::first();

        // API URL
        $api_url = "https://lucysrosedata.com/api/user/";

        // Ensure site_token exists in the configuration
        if (! $configuration || ! $configuration->site_token) {
            return response()->json(['error' => 'API token is missing in settings.'], 400);
        }

        // Prepare API key for authorization
        $api_key = "Token " . $configuration->site_token;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $api_key", // Authorization header with the API token
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Handle errors with the cURL request
        if (curl_errno($ch)) {
            $error_msg = 'Curl error: ' . curl_error($ch);
            curl_close($ch); // Close cURL session
            return response()->json(['error' => $error_msg], 500);
        }

        // Get HTTP response code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($ch);

        // Check for a successful response
        if ($http_code != 200) {
            return response()->json(['error' => 'Failed to fetch user data from the API.'], $http_code);
        }

        // Decode the JSON response
        $data = json_decode($response, true);

        // Handle the data (you can check for the 'user' field here)
        $usersd = $data['user'] ?? null;

        if (! $usersd) {
            return response()->json(['error' => 'User data not found.'], 404);
        }

        $totalUserBalance = $usersd['Account_Balance'] ?? 0.00; // User account balance

        return view('admin-layout.index', compact('user', 'userCount', 'totalUserBalance', 'totalCreditedAmount', 'totalDebitedAmount', 'totalUserBalance'));
    }

    public function manage()
    {
        // Retrieve all users from the users table
        $users = User::orderBy('created_at', 'desc')->get();

        // Pass the user data to the view
        return view('admin-layout.manageAccount', ['users' => $users]);
    }

    public function creditUserAccount()
    {
        // Fetch all users and order by 'created_at' in descending order
        $users = User::orderBy('created_at', 'desc')->get();

        // Fetch fund transactions where 'identity' contains 'Manual Funding' and order by 'created_at' in descending order
        $fundAccount = FundTransaction::where('identity', 'like', '%Manual Funding%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin-layout.creditUserAccount', ['users' => $users], ['fundAccount' => $fundAccount]);
    }

    public function addCharge($id)
    {
        $airtimes = percentage::find($id);
        return view('admin-layout.addChargeAirtime', compact('airtimes'));
    }

    public function editUser($id)
    {
        // Fetch the user by ID and pass it to the view
        $user = User::find($id);
        return view('admin-layout.editUser', compact('user'));
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

    public function addFund($id)
    {
        $user = User::find($id);
        return view('admin-layout.addFund', compact('user'));
    }

    public function approveFund($id)
    {
        $funding = FundTransaction::find($id);
        return view('admin-layout.approveFund', compact('funding'));
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
                'user_id'        => $user->id,
                'username'       => $user->username,
                'tel'            => $user->tel,
                'amount'         => $amount,
                'transaction_id' => 'TXN-' . now()->format('YmdHis') . Str::random(5),
                'identity'       => 'Manual Funding',
                'status'         => 'Success',
                'prev_bal'       => $user->account_balance,
                'current_bal'    => $user->account_balance += $amount,
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

    public function adminAirtime()
    {
        // Retrieve all airtime transactions
        $airtime_transaction = AirtimeTransaction::orderBy('created_at', 'desc')->get();

        // Retrieve only the percentages for specific services
        $airtimes = percentage::whereIn('service', [
            'MTN_Airtime_VTU',
            'Airtel_Airtime_VTU',
            'GLO_Airtime_VTU',
            '9mobile_Airtime_VTU',
        ])->get();

        return view('admin-layout.airtime', [
            'airtimes'            => $airtimes,
            'airtime_transaction' => $airtime_transaction,
        ]);
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
        $airtime = percentage::find($id);

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

    public function adminData()
    {

        // Retrieve all airtime transactions
        $airtime_transaction = AirtimeTransaction::orderBy('created_at', 'desc')->get();

        // Retrieve only the percentages for specific services
        $airtimes = percentage::whereIn('service', [
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
        return view('admin-layout.data', [
            'airtimes'         => $airtimes,
            'data_transaction' => $data_transaction,
        ]);
    }

    public function adminElectricity()
    {
        // Retrieve all airtime transactions
        $airtime_transaction = AirtimeTransaction::orderBy('created_at', 'desc')->get();
        // Retrieve only the percentages for specific services
        $airtimes = percentage::whereIn('service', [
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
        return view('admin-layout.electricity', [
            'airtimes'               => $airtimes,
            'eletricity_transaction' => $eletricity_transaction,
        ]);
    }

    public function adminTv()
    {

        // Retrieve only the percentages for specific services
        $airtimes = percentage::whereIn('service', [
            'Gotv_Payment',
            'Dstv_Payment',
            'Startime_Payment',
            'Showmax_Payment',
        ])->get();

        $tv_transaction = TvTransactions::orderBy('created_at', 'desc')->get();
        return view('admin-layout.cableTv', [
            'airtimes'       => $airtimes,
            'tv_transaction' => $tv_transaction,
        ]);
    }

    public function message()
    {
        $message_user = User::orderBy('created_at', 'desc')->get();
        return view('admin-layout.message', [
            'message_user' => $message_user,
        ]);
    }

    public function notification()
    {
        // Fetch all notifications/messages from the database
        $notifications = UserMessage::orderBy('created_at', 'desc')->get();

        return view('admin-layout.notification', compact('notifications'));
    }

    public function site_setting()
    {
        $settings = Setting::first();
        $user     = Auth::user(); // Get the currently authenticated user
                                  // Show the current fee (default from config if no session value)

        $target = storage_path('app/public');
        $link   = public_path('storage');

// Check if the symbolic link already exists
        if (! file_exists($link)) {
            symlink($target, $link);

        }

        return view('admin-layout.site-setting', compact('settings', 'user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('admin-layout.editUser', [
            'user' => $user,
        ]);
    }

    public function adminupdates(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255',
            'tel'      => 'required|string|max:15',
            'address'  => 'required|string',
            'password' => 'nullable|confirmed|min:6', // Validate password confirmation
            'upgrade'  => 'nullable|integer',         // Ensure upgrade is an integer if provided
        ]);

        // Find the user or return 404 if not found
        $user = User::findOrFail($id);

                                      // Check and update earner fields based on upgrade value
        $isUpgradedToTopUser = false; // Track if the user is upgraded to topuser

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
                $referrer->increment('account_balance', 500);
                $referrer->increment('refferal_bonus', 500);
            }
        }

        // Save the user
        $user->save();

        // Redirect or return response
        return redirect()->route('edit.user', ['id' => $user->id])
            ->with('success', 'User updated successfully.');
    }

    public function adminEducation()
    {
        // Retrieve only the percentages for specific services
        $airtimes = percentage::whereIn('service', [
            'WAEC_Result_Checker_PIN',
            'WAEC_Registration_PIN',

        ])->get();

        $education_transaction = EducationTransaction::orderBy('created_at', 'desc')->get();
        return view('admin-layout.education', [
            'airtimes'              => $airtimes,
            'education_transaction' => $education_transaction,
        ]);
    }

    public function adminInsurance()
    {
        // Retrieve only the percentages for specific services
        $airtimes = percentage::whereIn('service', [
            'Personal_Accident_Insurance',
            'Third_Party_Motor_Insurance_-_Universal_Insurance',

        ])->get();

        $insurance_transaction = InsuranceTransaction::all();
        return view('admin-layout.insurance', [
            'airtimes'              => $airtimes,
            'insurance_transaction' => $insurance_transaction,
        ]);
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
        return view('admin-layout.message_user', compact('user'));
    }

    public function sendMessage(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Validate the request data
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Logic to send the message (e.g., save to database, send an email, etc.)
        // For example:
        Notification::create([
            'username' => $user->username,
            'msghead'  => $request->subject, // Correctly adding a newline between the subject and the message
            'msgbody'  => $request->message, // Correctly adding a newline between the subject and the message
        ]);

        // Redirect back with a success message
        return redirect()->route('message.user', $id)->with('success', 'Message sent successfully.');
    }

    // Update the site settings
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
            return redirect()->route('site_setting')->with('success', 'Settings updated successfully.');
        }

        return redirect()->route('site_setting')->with('error', 'Failed to update settings.');
    }

    public function walletSummaryadmin()
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

        return view('admin-layout.wallet', compact('allTransactions'));
    }

    public function add_account()
    {
        return view('admin-layout.add_account');
    }

    public function addnewAccount(Request $request)
    {
        // Validation rules for the form inputs
        $validator = Validator::make($request->all(), [
            'user_role' => 'required|in:1,2',
            'fname'     => 'required',
            'username'  => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'tel'       => [
                'required',
                'regex:/^0\d{10}$/', // Ensure the phone number starts with '0' and is followed by 10 digits
                'unique:users',
            ],
            'address'   => 'required',
            'password'  => 'required|max:20|min:6',
            'cpassword' => 'required|same:password',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

                                                       // Default values for user registration
        $role           = $request->user_role;         // Get the selected user role
        $refferal_user  = $request->input('referral'); // Get referral username from the request
        $refferal       = 0;
        $refferal_bonus = 0.0;
        $cal            = 1;

                                                                  // Generate a unique user_id
        $randomString = strtoupper(substr(md5(mt_rand()), 0, 8)); // Generate a random 8-character string
        $latestUserId = User::max('id') + 1;                      // Fetch the next auto-increment ID
        $userId       = 'UID' . $randomString . $latestUserId;    // Combine strings to form a unique user ID

        // Data array for creating a new user
        $data = [
            'name'           => $request->fname,
            'user_id'        => $userId, // Assign the generated user_id
            'username'       => $request->username,
            'address'        => $request->address,
            'email'          => $request->email,
            'tel'            => $request->tel,
            'password'       => Hash::make($request->password),
            'role'           => $role,
            'cal'            => $cal,
            'refferal_user'  => $refferal_user ?? null, // Set nullable if referral user is not provided
            'refferal'       => $refferal,
            'refferal_bonus' => $refferal_bonus,
        ];

        // Create the user
        $user = User::create($data);

        if ($user) {
            // Handle referral logic if there's a referral user
            if ($refferal_user) {
                $referrer = User::where('user_id', $refferal_user)->first();

                if ($referrer) {
                    // Create referral record
                    Referral::create([
                        'user_id'           => $referrer->user_id, // ID of the referring user
                        'referral_user_id'  => $user->user_id,     // ID of the referred user
                        'referral_username' => $user->username,    // Referred user's username
                    ]);
                }
            }

            // Redirect to the login page with success message
            return redirect(route('add_account'))->with('success', 'Registration successful, Send User Login.');
        } else {
            // Redirect to the registration page with error message
            return redirect()->back()->with('error', 'Registration failed, try again.');
        }
    }

    public function marchant()
    {

        // Retrieve all users with role 1, ordered by created_at in descending order
        $users = User::where('role', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass the user data to the view
        return view('admin-layout.viewMarchant', ['users' => $users]);
    }

    public function manageSubAdmin()
    {
                                   // Fetch all merchant pages from the merchants model
        $pages = merchants::all(); // Use the correct model name (should be singular by convention)

        // Return the view and pass the 'pages' data
        return view('admin-layout.marchant', compact('pages'));
    }

    public function updatePageStatus($id, $action)
    {
        try {
            $page = merchants::findOrFail($id);

            if ($action === 'activate') {
                $page->action = 1;
            } elseif ($action === 'deactivate') {
                $page->action = 0;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid action provided.',
                ], 400);
            }

            $page->save();

            return response()->json([
                'success' => true,
                'message' => 'Page status updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the status.',
            ], 500);
        }
    }

    public function getMonnifyFee()
    {
        // Retrieve the monnify_percent from the Setting model
        $settings = Setting::first();

        // If no value is found, fallback to a default (e.g., 1.7)
        $monnifyFee = $settings->monnify_percent;

        return response()->json([
            'fee' => $monnifyFee,
        ]);
    }
}
