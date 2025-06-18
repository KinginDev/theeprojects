<?php
namespace App\Http\Controllers;

use App\Models\EducationTransaction;
use App\Models\EletricityTransaction;
use App\Models\InsuranceTransaction;
use App\Models\Notification;
use App\Models\percentage;
use App\Models\Setting;
use App\Models\TvTransactions;
use App\Models\User;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class utilitiesPaymentController extends Controller
{
    public function indexElectricity()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData      = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();

            return view('users-layout.dashboard.electricity', [
                'userData'      => $userData,
                'notifications' => $notifications,
            ]);
        }
    }

    public function purchaseElectricity(Request $request)
    {
        // Validate the request
        $request->validate([
            'distribution_company' => 'required|in:ikeja-electric,eko-electric,abuja-electric,kano-electric,portharcourt-electric,jos-electric,kaduna-electric,enugu-electric,ibadan-electric,benin-electric,aba-electric,yola-electric',
            'type'                 => 'required|in:prepaid,postpaid',
            'meter_number'         => 'required',
            'tel'                  => 'required|numeric',
            'email'                => 'required|email',
            'amount'               => 'required|numeric',
        ]);

        // Get the input values
        $distributionCompany = $request->input('distribution_company');
        $meterNumber         = $request->input('meter_number');
        $type                = $request->input('type');
        $tel                 = $request->input('tel');
        $email               = $request->input('email');
        $amount              = $request->input('amount');

        // Retrieve the authenticated user and balance
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Check if the user has sufficient funds
        if ($userBalance < $amount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient funds']);
        }

        // Map service IDs to the corresponding service names
        $serviceMap = [
            'ikeja-electric'        => 'Ikeja_Electric_Payment_-_IKEDC',
            'eko-electric'          => 'Eko_Electric_Payment_-_EKEDC',
            'abuja-electric'        => 'Abuja_Electricity_Distribution_Company_-_AEDC',
            'kano-electric'         => 'KEDCO_-_Kano_Electric',
            'portharcourt-electric' => 'PHED_-_Port_Harcourt_Electric',
            'jos-electric'          => 'Jos_Electric_-_JED',
            'kaduna-electric'       => 'Kaduna_Electric_-_KAEDCO',
            'enugu-electric'        => 'Enugu_Electric_-_EEDC',
            'ibadan-electric'       => 'IBEDC_-_Ibadan_Electricity_Distribution_Company',
            'benin-electric'        => 'Benin_Electricity_-_BEDC',
            'aba-electric'          => 'Aba_Electric_Payment_-_ABEDC',
            'yola-electric'         => 'Yola_Electric_Disco_Payment_-_YEDC',
        ];

        $serviceID = strtolower($distributionCompany);

        // Check if the service ID exists in the map
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            // Calculate final amount after applying percentage deductions based on user type
            if ($percentage) {
                if ($smart_earners == 1) {
                    $smartEarnerPercent = $percentage->smart_earners_percent;
                    $deduction          = ($smartEarnerPercent / 100) * $amount;
                    $finalAmount        = $amount - $deduction;
                } elseif ($topuser_earners == 1) {
                    $topuserEarnerPercent = $percentage->topuser_earners_percent;
                    $deduction            = ($topuserEarnerPercent / 100) * $amount;
                    $finalAmount          = $amount - $deduction;
                } elseif ($api_earners == 1) {
                    $apiEarnerPercent = $percentage->api_earners_percent;
                    $deduction        = ($apiEarnerPercent / 100) * $amount;
                    $finalAmount      = $amount - $deduction;
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }

                // Round up the final amount to the nearest whole number
                $finalAmount = ceil($finalAmount);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected distribution company']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid distribution company']);
        }

        // Verify the meter number
        $verificationResult = $this->verifyMeterNumber($meterNumber, $type, $distributionCompany);
        if ($verificationResult['status'] !== 'verified') {
            return response()->json($verificationResult);
        }

        // Get the current time and generate a request ID
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");
        $request_id     = $formatted_time . "89htyyo";

        $configuration = Setting::first();

        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->airtime_api_url;

        // API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "billersCode"    => $meterNumber,
            "variation_code" => $type,
            "amount"         => $amount, // Use finalAmount after deductions and rounding
            "phone"          => $tel,
            "email"          => $email,
        ];

        try {
            // Call the API
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the API response
            $result = json_decode($response->getBody());

            // Check if the transaction was successful
            if (isset($result->content->transactions->status) && $result->content->transactions->status === "delivered") {
                // Update user's balance
                $currentBal = $userBalance - $finalAmount;
                User::where('id', $user->id)->update(['account_balance' => $currentBal]);

                // Calculate percentage profit
                $percentProfit = $amount - $finalAmount;

                // Create the transaction record
                EletricityTransaction::create([
                    'username'             => $user->username,
                    'product_name'         => $serviceMap[$serviceID],
                    'type'                 => $type,
                    'tel'                  => $tel,
                    'amount'               => $amount,
                    'reference'            => $result->requestId ?? null,
                    'purchased_code'       => $result->purchased_code ?? null,
                    'response_description' => $result->response_description ?? 'No description provided',
                    'transaction_date'     => now(),
                    'identity'             => $meterNumber,
                    'prev_bal'             => $userBalance,
                    'current_bal'          => $currentBal,
                    'percent_profit'       => $percentProfit,
                    'status'               => 'successful',
                ]);

                // Return success response
                return response()->json(['status' => 'delivered', 'message' => 'Electricity purchase successful', 'result' => $result]);
            } else {
                // Return failure response
                return response()->json(['status' => 'failed', 'message' => 'Electricity purchase failed', 'result' => $result]);
            }
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    private function verifyMeterNumber($meterNumber, $type, $distributionCompany)
    {
        $configuration = Setting::first();
        // Set up Guzzle client for meter verification
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data for meter verification
        $verificationData = [
            "billersCode" => $meterNumber,
            "serviceID"   => $distributionCompany,
            "type"        => $type,
        ];

        try {
            // Set up cURL config for meter verification
            $verificationResponse = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $verificationData,
            ]);

            // Decode the response for meter verification
            $verificationResult = json_decode($verificationResponse->getBody());

            // Check if the meter verification was successful
            if (isset($verificationResult->code) && $verificationResult->code === "000") {
                return ['status' => 'verified', 'message' => 'Meter number verified'];
            } else {
                return ['status' => 'failed', 'message' => 'Meter number verification failed', 'result' => $verificationResult];
            }
        } catch (\Exception $e) {
            // Return an error response with exception details for meter verification
            return ['status' => 'failed', 'message' => 'Error during meter verification API request', 'exception' => $e->getMessage()];
        }
    }

    public function indexTv()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();

            $notifications = Notification::where('username', $user->username)->get();

            return view('users-layout.dashboard.tv', [
                'userData'      => $userData,
                'notifications' => $notifications,
            ]);
        }
    }

    public function billCodeDstv(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode' => 'required|string',
        ]);

        // Process the form data
        $smartCardNumber = 'dstv';
        $billerCode      = $request->input('billerCode');

                                     // Assuming you have a User model with an 'account_balance' field
        $user        = Auth::user(); // Retrieve the authenticated user
        $userBalance = $user->account_balance;

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }
        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data
        $data = [
            "serviceID"   => $smartCardNumber,
            "billersCode" => $billerCode,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function billCodeGotv(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode' => 'required|string',
        ]);

        // Process the form data
        $smartCardNumber = 'gotv';
        $billerCode      = $request->input('billerCode');

                                     // Assuming you have a User model with an 'account_balance' field
        $user        = Auth::user(); // Retrieve the authenticated user
        $userBalance = $user->account_balance;

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }
        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data
        $data = [
            "serviceID"   => $smartCardNumber,
            "billersCode" => $billerCode,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function billCodeStartime(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode' => 'required',
        ]);

        // Process the form data
        $smartCardNumber = 'startimes';
        $billerCode      = $request->input('billerCode');

                                     // Assuming you have a User model with an 'account_balance' field
        $user        = Auth::user(); // Retrieve the authenticated user
        $userBalance = $user->account_balance;

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }
        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data
        $data = [
            "serviceID"   => $smartCardNumber,
            "billersCode" => $billerCode,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function billCodeShowmax(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode' => 'required|string',
        ]);

        // Process the form data
        $smartCardNumber = 'showmax';
        $billerCode      = $request->input('billerCode');

                                     // Assuming you have a User model with an 'account_balance' field
        $user        = Auth::user(); // Retrieve the authenticated user
        $userBalance = $user->account_balance;

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }
        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data
        $data = [
            "serviceID"   => $smartCardNumber,
            "billersCode" => $billerCode,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function changeBouquet(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode'    => 'required|integer',
            'bouquet'       => 'required|string',
            'selectBouquet' => 'required|string',
            'tel'           => 'required|numeric',
            'amount'        => 'required|numeric',
        ]);

        // Process the form data
        $serviceID         = $request->input('serviceId');
        $variation_code    = $request->input('selectBouquet');
        $amount            = $request->input('amount');
        $billerCode        = $request->input('billerCode');
        $phone             = $request->input('tel');
        $subscription_type = $request->input('bouquet');
        $quantity          = 1;

        // Retrieve authenticated user and balance
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to the corresponding service names in the database
        $serviceMap = [
            'dstv' => 'Dstv_Payment',
            'gotv' => 'Gotv_Payment',
        ];

        // Initialize finalAmount with the original amount
        $finalAmount = $amount;

        // Apply the correct deduction based on the user's role
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceMap[$serviceID])->first();

            if ($percentage) {
                if ($smart_earners == 1) {
                    $smartEarnerPercent = $percentage->smart_earners_percent;
                    $deduction          = ($smartEarnerPercent / 100) * $amount;
                    $finalAmount        = $amount - $deduction;
                } elseif ($topuser_earners == 1) {
                    $topuserEarnerPercent = $percentage->topuser_earners_percent;
                    $deduction            = ($topuserEarnerPercent / 100) * $amount;
                    $finalAmount          = $amount - $deduction;
                } elseif ($api_earners == 1) {
                    $apiEarnerPercent = $percentage->api_earners_percent;
                    $deduction        = ($apiEarnerPercent / 100) * $amount;
                    $finalAmount      = $amount - $deduction;

                    $finalAmount = ceil($finalAmount);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected network']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Check if user has sufficient balance after applying discounts
        if ($userBalance < $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient funds']);
        }

        // Get the current timestamp and generate a request ID
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");
        $request_id     = $formatted_time . Str::random(5);

        // Get API configuration
        $configuration = Setting::first();
        $client        = new Client();
        $apiUrl        = $configuration->airtime_api_url;

        // Prepare API request data
        $data = [
            "request_id"        => $request_id,
            "serviceID"         => $serviceID,
            "billersCode"       => $billerCode,
            "variation_code"    => $variation_code,
            "amount"            => $amount,
            "phone"             => $phone,
            "subscription_type" => $subscription_type,
            "quantity"          => $quantity,
        ];

        try {
            // Make API request
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the API response
            $result = json_decode($response->getBody(), true);

            if ($result && isset($result['content']['transactions']['status']) && $result['content']['transactions']['status'] === 'delivered') {
                // Deduct the final amount from the user's balance
                $currentBal    = $userBalance - $finalAmount;
                $percentProfit = $amount - $finalAmount;

                User::where('id', $user->id)->update(['account_balance' => $currentBal]);

                // Insert transaction data into the tv_transactions table
                TvTransactions::create([
                    'username'       => $user->username,
                    'api_response'   => $result['response_description'] ?? 'No description provided',
                    'network'        => $subscription_type,
                    'tel'            => $phone,
                    'plan'           => $billerCode,
                    'amount'         => $amount,
                    'reference'      => $result['requestId'],
                    'identity'       => $result['content']['transactions']['product_name'] ?? 'Unknown Product',
                    'prev_bal'       => $userBalance,
                    'current_bal'    => $currentBal,
                    'percent_profit' => $percentProfit,
                    'status'         => 'successful',
                ]);

                // Return success response
                return response()->json(['status' => 'initiated', 'message' => Str::upper($serviceID) . ' Subscription successful', 'result' => $result]);
            } else {
                // Return failure response
                return response()->json(['status' => 'failed', 'message' => Str::upper($serviceID) . ' Subscription failed', 'result' => $result]);
            }
        } catch (\Exception $e) {
            // Return error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function renewBouquet(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode' => 'required|integer',
            'bouquet'    => 'required|string',
            'tel'        => 'required|numeric',
            'amount'     => 'required|numeric',
        ]);

        // Process the form data
        $serviceID         = $request->input('serviceId');
        $amount            = $request->input('amount');
        $billerCode        = $request->input('billerCode');
        $phone             = $request->input('tel');
        $subscription_type = $request->input('bouquet');

        // Retrieve authenticated user and balance
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'dstv' => 'Dstv_Payment',
            'gotv' => 'Gotv_Payment',
        ];

        // Initialize finalAmount with the original amount
        $finalAmount = $amount;

        // Apply deductions based on user's earner type
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceMap[$serviceID])->first();

            if ($percentage) {
                if ($smart_earners == 1) {
                    $smartEarnerPercent = $percentage->smart_earners_percent;
                    $deduction          = ($smartEarnerPercent / 100) * $amount;
                    $finalAmount        = $amount - $deduction;
                } elseif ($topuser_earners == 1) {
                    $topuserEarnerPercent = $percentage->topuser_earners_percent;
                    $deduction            = ($topuserEarnerPercent / 100) * $amount;
                    $finalAmount          = $amount - $deduction;
                } elseif ($api_earners == 1) {
                    $apiEarnerPercent = $percentage->api_earners_percent;
                    $deduction        = ($apiEarnerPercent / 100) * $amount;
                    $finalAmount      = $amount - $deduction;

                    $finalAmount = ceil($finalAmount);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected network']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Check if user has sufficient balance
        if ($userBalance < $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient balance']);
        }

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate request ID
        $request_id = $formatted_time . Str::random(5);

        // Fetch API configuration
        $configuration = Setting::first();
        $apiUrl        = $configuration->airtime_api_url;

        // Set up Guzzle client
        $client = new Client();

        // Prepare API request data
        $data = [
            "request_id"        => $request_id,
            "serviceID"         => $serviceID,
            "billersCode"       => $billerCode,
            "amount"            => $amount,
            "phone"             => $phone,
            "subscription_type" => $subscription_type,
        ];

        try {
            // Make API request
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the API response
            $result = json_decode($response->getBody(), true);

            if ($result) {
                // Deduct final amount from user's balance
                $currentBal = $userBalance - $finalAmount;
                User::where('id', $user->id)->update(['account_balance' => $currentBal]);

                // Calculate the profit amount
                $percentProfit = $amount - $finalAmount;

                // Log the transaction
                TvTransactions::create([
                    'username'       => $user->username,
                    'api_response'   => $result['response_description'] ?? 'No description provided',
                    'network'        => $subscription_type,
                    'tel'            => $phone,
                    'plan'           => $billerCode,
                    'amount'         => $finalAmount,
                    'reference'      => $result['requestId'],
                    'identity'       => $result['content']['transactions']['product_name'] ?? 'Unknown Product',
                    'prev_bal'       => $userBalance,
                    'current_bal'    => $currentBal,
                    'percent_profit' => $percentProfit, // Store the actual profit amount
                    'status'         => 'successful',
                ]);

                // Return success response
                return response()->json(['status' => 'initiated', 'message' => Str::upper($serviceID) . ' Subscription successful', 'result' => $result]);
            } else {
                // Return failure response
                return response()->json(['status' => 'failed', 'message' => Str::upper($serviceID) . ' Subscription failed', 'result' => $result]);
            }
        } catch (\Exception $e) {
            // Return error response
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function bouquetStartime(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode'    => 'required|integer',
            'selectBouquet' => 'required|string',
            'tel'           => 'required|numeric',
            'amount'        => 'required|numeric',
        ]);

        // Process form data
        $serviceID     = 'startimes';
        $amount        = $request->input('amount');
        $billerCode    = $request->input('billerCode');
        $selectBouquet = $request->input('selectBouquet');
        $phone         = $request->input('tel');

        // Retrieve authenticated user and account balance
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User roles
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'startimes' => 'Startime_Payment',
        ];

        // Initialize finalAmount with the original amount
        $finalAmount   = $amount;
        $percentProfit = 0;

        // Apply deductions based on user's earner type
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            if ($percentage) {
                if ($smart_earners == 1) {
                    $smartEarnerPercent = $percentage->smart_earners_percent;
                    $deduction          = ($smartEarnerPercent / 100) * $amount;
                    $finalAmount        = $amount - $deduction;
                } elseif ($topuser_earners == 1) {
                    $topuserEarnerPercent = $percentage->topuser_earners_percent;
                    $deduction            = ($topuserEarnerPercent / 100) * $amount;
                    $finalAmount          = $amount - $deduction;
                } elseif ($api_earners == 1) {
                    $apiEarnerPercent = $percentage->api_earners_percent;
                    $deduction        = ($apiEarnerPercent / 100) * $amount;
                    $finalAmount      = $amount - $deduction;
                    $finalAmount      = ceil($finalAmount);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected service']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Ensure the user has enough balance
        if ($userBalance < $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient balance']);
        }

        // Generate a request ID
        $current_time = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $request_id   = $current_time->format("YmdHis") . str_pad('89htyyo', 12, 'x');

        // Retrieve API configuration
        $configuration = Setting::first();
        $apiUrl        = $configuration->airtime_api_url;

        // Set up API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "billersCode"    => $billerCode,
            "amount"         => $amount,
            "phone"          => $phone,
            "variation_code" => $selectBouquet,
        ];

        // Set up Guzzle client
        $client = new Client();

        try {
            // Send API request
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            if ($result) {
                // Deduct the amount from user's balance
                $currentBal = $userBalance - $finalAmount;
                User::where('id', $user->id)->update(['account_balance' => $currentBal]);

                $percentProfit = $amount - $finalAmount;
                // Log transaction
                TvTransactions::create([
                    'username'       => $user->username,
                    'api_response'   => $result['response_description'] ?? 'No description provided',
                    'network'        => $selectBouquet,
                    'tel'            => $phone,
                    'plan'           => $billerCode,
                    'amount'         => $finalAmount,
                    'reference'      => $result['requestId'],
                    'identity'       => $result['content']['transactions']['product_name'] ?? 'Unknown Product',
                    'prev_bal'       => $userBalance,
                    'current_bal'    => $currentBal,
                    'percent_profit' => $percentProfit,
                    'status'         => 'successful',
                ]);

                // Return success response
                return response()->json(['status' => 'initiated', 'message' => 'Startimes Subscription successful', 'result' => $result]);
            } else {
                // Return error response
                return response()->json(['status' => 'failed', 'message' => 'Startimes Subscription failed', 'result' => $result]);
            }
        } catch (\Exception $e) {
            // Return error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function bouquetShowmax(Request $request)
    {
        // Validate the request
        $request->validate([
            'selectBouquet' => 'required|string',
            'tel'           => 'required|numeric',
            'amount'        => 'required|numeric',
        ]);

        // Process the form data
        $serviceID     = 'showmax';
        $amount        = $request->input('amount');
        $selectBouquet = $request->input('selectBouquet');
        $phone         = $request->input('tel');

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User roles
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'showmax' => 'Showmax_Payment',
        ];

        // Initialize finalAmount with the original amount
        $finalAmount         = $amount;
        $percentProfitAmount = 0;

        // Check if service exists in the map
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            if ($percentage) {
                // Calculate deduction based on earner type
                if ($smart_earners == 1) {
                    $smartEarnerPercent  = $percentage->smart_earners_percent;
                    $percentProfitAmount = ($smartEarnerPercent / 100) * $amount; // Calculate profit in amount
                    $finalAmount         = $amount - $percentProfitAmount;
                } elseif ($topuser_earners == 1) {
                    $topuserEarnerPercent = $percentage->topuser_earners_percent;
                    $percentProfitAmount  = ($topuserEarnerPercent / 100) * $amount;
                    $finalAmount          = $amount - $percentProfitAmount;
                } elseif ($api_earners == 1) {
                    $apiEarnerPercent    = $percentage->api_earners_percent;
                    $percentProfitAmount = ($apiEarnerPercent / 100) * $amount;
                    $finalAmount         = $amount - $percentProfitAmount;
                    $finalAmount         = ceil($finalAmount);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected service']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Ensure the user has enough balance
        if ($userBalance < $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient balance']);
        }

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }

        // Retrieve configuration
        $configuration = Setting::first();
        $apiUrl        = $configuration->airtime_api_url;

        // Set up API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "billersCode"    => $phone,
            "amount"         => $amount, // Send the finalAmount to the API
            "variation_code" => $selectBouquet,
            "phone"          => $phone,
        ];

        // Set up Guzzle client
        $client = new Client();

        try {
            // Make the API request
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            if ($result && isset($result['requestId'])) {
                // Deduct the amount from the user's balance
                $currentBal = $userBalance - $finalAmount;
                User::where('id', $user->id)->update(['account_balance' => $currentBal]);

                // Save transaction in the database
                TvTransactions::create([
                    'username'       => $user->username,
                    'api_response'   => $result['response_description'] ?? 'No description provided',
                    'network'        => $result['content']['transactions']['product_name'] ?? 'Unknown Product',
                    'tel'            => $phone,
                    'plan'           => $phone,
                    'amount'         => $finalAmount,
                    'reference'      => $result['requestId'],
                    'identity'       => $result['content']['transactions']['product_name'] ?? 'Unknown Product',
                    'prev_bal'       => $userBalance,
                    'current_bal'    => $currentBal,
                    'percent_profit' => $percentProfitAmount, // Save profit in amount
                    'status'         => 'successful',
                ]);

                // Return success response
                return response()->json(['status' => 'initiated', 'message' => 'Showmax Subscription successful', 'result' => $result]);
            } else {
                // Return error if API request failed
                return response()->json(['status' => 'failed', 'message' => 'Showmax Subscription failed', 'result' => $result]);
            }
        } catch (\Exception $e) {
            // Return error if an exception occurs
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function meterCodeVerify(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode'          => 'required|string',
            'meterType'           => 'required|string',
            'distributionCompany' => 'required|string',
        ]);

        // Process the form data
        $billerCode          = $request->input('billerCode');
        $meterType           = $request->input('meterType');
        $distributionCompany = $request->input('distributionCompany');

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }
        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data
        $data = [
            "billersCode" => $billerCode,
            "serviceID"   => $distributionCompany,
            "type"        => $meterType,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function education()
    {

        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();

        // Define the API URLs

        $apiUrlSandbox = $configuration->education_waec_api_url;

        try {

            $responseSandbox = $client->get($apiUrlSandbox, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $resultSandbox = json_decode($responseSandbox->getBody(), true);

            $user = Auth::user();

            if ($user) {
                // Retrieve all data for the user from the database
                $userData = User::where('id', $user->id)->first();

                $notifications = Notification::where('username', $user->username)->get();

                // Pass both results to the view
                return view('users-layout.dashboard.WAECregistration', [
                    'userData'      => $userData,
                    'notifications' => $notifications,
                ], compact('resultSandbox'));
            }
        } catch (\Exception $e) {
            // Handle any errors that may occur during the API request
            return back()->with('error', 'Failed to retrieve data from the API: ' . $e->getMessage());
        }
    }

    public function waec_check_details(Request $request)
    {
        // Validate the request
        $request->validate([
            'examType'    => 'required|string',
            'quantity'    => 'required|string',
            'phoneNumber' => 'required|string',
            'amount'      => 'required|string',
        ]);

                                                               // Process the form data
        $serviceID      = 'waec-registration';                 // This will be your serviceID (waec-registration)
        $quantity       = intval($request->input('quantity')); // Ensure this is an integer
        $phoneNumber    = $request->input('phoneNumber');
        $amount         = floatval($request->input('amount')); // Ensure this is a float for precision
        $variation_code = $request->input('examType');         // Assuming examType is the variation code as well

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User roles
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'waec-registration' => 'WAEC_Registration_PIN',
        ];

        // Initialize finalAmount and profit
        $finalAmount       = $amount;
        $fixedProfitAmount = 0;

        // Check if service exists in the map
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            if ($percentage) {
                // Use absolute profit amount instead of percentage
                if ($smart_earners == 1) {
                    $fixedProfitAmount = floatval($percentage->smart_earners_percent) * $quantity; // Fixed amount calculation
                    $finalAmount       = $amount - $fixedProfitAmount;
                } elseif ($topuser_earners == 1) {
                    $fixedProfitAmount = floatval($percentage->topuser_earners_percent) * $quantity;
                    $finalAmount       = $amount - $fixedProfitAmount;
                } elseif ($api_earners == 1) {
                    $fixedProfitAmount = floatval($percentage->api_earners_percent) * $quantity;
                    $finalAmount       = $amount - $fixedProfitAmount;
                    $finalAmount       = ceil($finalAmount);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected service']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Generate a unique request ID
        $current_time     = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time   = $current_time->format("YmdHis");
        $additional_chars = bin2hex(random_bytes(4));
        $request_id       = $formatted_time . $additional_chars;

        $configuration = Setting::first();
        $client        = new Client();
        $apiUrl        = $configuration->airtime_api_url;

        // API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "variation_code" => $variation_code,
            "amount"         => $amount,
            "quantity"       => $quantity,
            "phone"          => $phoneNumber,
        ];

        try {
            // Send the API request
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            $result = json_decode($response->getBody(), true);

            // Handle successful transaction
            if (isset($result['code']) && $result['code'] === '000') {
                // Deduct amount from user's balance
                User::where('id', $user->id)->update(['account_balance' => $userBalance - $finalAmount]);

                // Insert the transaction data
                EducationTransaction::create([
                    'username'             => $user->username,
                    'product_name'         => 'WAEC Registration',
                    'type'                 => $variation_code,
                    'tel'                  => $phoneNumber,
                    'amount'               => $amount,
                    'reference'            => $result['requestId'],
                    'purchased_code'       => $result['purchased_code'] ?? null,
                    'response_description' => $result['response_description'] ?? 'No description provided',
                    'transaction_date'     => now(),
                    'identity'             => 'waec',
                    'prev_bal'             => $userBalance,
                    'current_bal'          => $userBalance - $finalAmount,
                    'percent_profit'       => $fixedProfitAmount, // Save the calculated profit as fixed amount
                    'status'               => 'successful',
                ]);
            }

            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function waec_check_result(Request $request)
    {
        // Validate the request
        $request->validate([
            'examType'    => 'required|string',
            'quantity'    => 'required|numeric', // Ensure this is a numeric value
            'phoneNumber' => 'required|string',
            'amount'      => 'required|numeric', // Ensure this is a numeric value
        ]);

                                  // Process the form data
        $serviceID      = 'waec'; // This will be your serviceID (waec-registration)
        $quantity       = intval($request->input('quantity'));
        $phoneNumber    = $request->input('phoneNumber');
        $amount         = floatval($request->input('amount')); // Convert amount to a float for accuracy
        $variation_code = $request->input('examType');         // Assuming examType is the variation code

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User roles
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'waec' => 'WAEC_Result_Checker_PIN',
        ];

        // Initialize finalAmount and profit
        $finalAmount       = $amount;
        $fixedProfitAmount = 0;

        // Check if service exists in the map
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            if ($percentage) {
                // Use fixed profit amounts instead of percentage
                if ($smart_earners == 1) {
                    $fixedProfitAmount = floatval($percentage->smart_earners_percent) * $quantity;
                    $finalAmount       = $amount - $fixedProfitAmount;
                } elseif ($topuser_earners == 1) {
                    $fixedProfitAmount = floatval($percentage->topuser_earners_percent) * $quantity;
                    $finalAmount       = $amount - $fixedProfitAmount;
                } elseif ($api_earners == 1) {
                    $fixedProfitAmount = floatval($percentage->api_earners_percent) * $quantity;
                    $finalAmount       = $amount - $fixedProfitAmount;
                    $finalAmount       = ceil($finalAmount);
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected service']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Generate a unique request ID
        $current_time     = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time   = $current_time->format("YmdHis");
        $additional_chars = bin2hex(random_bytes(4));
        $request_id       = $formatted_time . $additional_chars;

        $configuration = Setting::first();
        $client        = new Client();
        $apiUrl        = $configuration->airtime_api_url;

        // API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "variation_code" => $variation_code,
            "amount"         => $amount,
            "quantity"       => $quantity,
            "phone"          => $phoneNumber,
        ];

        try {
            // Send the API request
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            $result = json_decode($response->getBody(), true);

            // Handle successful transaction
            if (isset($result['code']) && $result['code'] === '000') {
                // Deduct amount from user's balance
                User::where('id', $user->id)->update(['account_balance' => $userBalance - $finalAmount]);

                // Insert the transaction data
                EducationTransaction::create([
                    'username'             => $user->username,
                    'product_name'         => 'waec',
                    'type'                 => $variation_code,
                    'tel'                  => $phoneNumber,
                    'amount'               => $amount,
                    'reference'            => $result['requestId'],
                    'purchased_code'       => $result['purchased_code'] ?? null,
                    'response_description' => $result['response_description'] ?? 'No description provided',
                    'transaction_date'     => now(),
                    'identity'             => 'waec',
                    'prev_bal'             => $userBalance,
                    'current_bal'          => $userBalance - $finalAmount,
                    'percent_profit'       => $fixedProfitAmount, // Save the calculated profit as fixed amount
                    'status'               => 'successful',
                ]);
            }

            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
        // Retrieve the requestId from the query parameters
        $requestId = $request->query('hash');

        // Attempt to find the transaction in the EducationTransaction table
        $transaction = EducationTransaction::where('reference', $requestId)->first();

        // If not found, try to find it in the InsuranceTransaction table
        if (! $transaction) {

            $transaction = InsuranceTransaction::where('reference', $requestId)->first();
        }

        // If still not found, try to find it in the EletricityTransaction table
        if (! $transaction) {
            $transaction = EletricityTransaction::where('reference', $requestId)->first();
        }

        // Check if the transaction was found
        if (! $transaction) {
            // Handle the case where no transaction is found
            return view('users-layout.dashboard.error', [
                'message' => 'Transaction not found.',
            ]);
        }
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            // Pass the data and the flag to the view
            $notifications = Notification::where('username', $user->username)->get();

            // Pass the transaction details to the success view
            return view('users-layout.dashboard.success', [
                'userData'      => $userData,
                'notifications' => $notifications,
            ], [
                'phoneNumber'          => $transaction->tel,
                'amount'               => $transaction->amount,
                'transactionId'        => $transaction->reference,
                'code'                 => $transaction->identity,
                'purchased_code'       => $transaction->purchased_code,
                'response_description' => $transaction->response_description,
                'tokens'               => $transaction->purchased_code ? explode(',', $transaction->purchased_code) : [],
                'transaction_date'     => $transaction->transaction_date,
            ]);
        }
    }
    public function jamb_verify(Request $request)
    {
        // Validate the request
        $request->validate([
            'billcode'  => 'required|numeric',
            'serviceID' => 'required|string',
            'type'      => 'required|string',
        ]);

        // Process the form data
        $billcode  = $request->input('billcode');
        $serviceID = $request->input('serviceID');
        $type      = $request->input('type');

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a random alphanumeric string
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }
        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->electricity_verify_api_url;

        // Set up API request data
        $data = [
            "billersCode" => $billcode,
            "serviceID"   => $serviceID,
            "type"        => $type,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function jamb_register(Request $request)
    {

        // Validate the request
        $request->validate([
            'examType'    => 'required|string',
            'billcode'    => 'required|numeric',
            'phoneNumber' => 'required|string',
            'amount'      => 'required|string',
        ]);

                                  // Process the form data
        $serviceID      = 'jamb'; // This will be your serviceID (waec-registration)
        $billcode       = $request->input('billcode');
        $phoneNumber    = $request->input('phoneNumber');
        $amount         = $request->input('amount');
        $variation_code = $request->input('examType'); // Assuming examType is the variation code as well

                                     // Assuming you have a User model with an 'account_balance' field
        $user        = Auth::user(); // Retrieve the authenticated user
        $userBalance = $user->account_balance;

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

                                                      // Generate a random alphanumeric string
        $additional_chars = bin2hex(random_bytes(4)); // More randomness for uniqueness
        $request_id       = $formatted_time . $additional_chars;
        $configuration    = Setting::first();
        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->airtime_api_url;

        // Set up API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "variation_code" => $variation_code,
            "amount"         => $amount,
            "billersCode"    => $billcode,
            "phone"          => $phoneNumber,
        ];

        try {
            // Set up cURL config
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);
            // Check if the transaction was successful
            if (isset($result['code']) && $result['code'] === '000') {
                // Deduct the amount from the user's balance
                User::where('id', $user->id)->update(['account_balance' => $userBalance - $amount]);

                // Insert the transaction data into the education_transactions table
                EducationTransaction::create([
                    'username'             => $user->username, // Assuming the user is authenticated
                    'product_name'         => 'Jamb',
                    'type'                 => $variation_code,
                    'tel'                  => $phoneNumber,
                    'amount'               => $amount,
                    'reference'            => $result['requestId'],
                    'purchased_code'       => $result['purchased_code'] ?? null,
                    'response_description' => $result['response_description'] ?? 'No description provided',
                    'transaction_date'     => now(),
                    'identity'             => 'Jamb',
                    'status'               => 'successful',
                ]);
            }

            // Return the result
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function insurance()
    {

        $configuration = Setting::first();
        // Set up Guzzle client
        $client = new Client();

        // Define the API URLs
        $apiUrlhealth_insurance = $configuration->insurance_health_insurance_api_url;

        $apiUrlui_insure = $configuration->insurance_ui_insure_api_url;
        $apiUrlState     = $configuration->insurance_state_api_url;
        $apiUrlColor     = $configuration->insurance_color_api_url;
        $apiUrlBrand     = $configuration->insurance_brand_api_url;

        try {
            // Fetch waec-registration data
            $responsehealth_insurance = $client->get($apiUrlhealth_insurance, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $resulthealth_insurance = json_decode($responsehealth_insurance->getBody(), true);

            // Fetch waec sandbox data
            $responseui_insure = $client->get($apiUrlui_insure, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $resultui_insure = json_decode($responseui_insure->getBody(), true);

            // Fetch state data
            $responseState = $client->get($apiUrlState, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $resultState = json_decode($responseState->getBody(), true);

            // Fetch color data
            $responseColor = $client->get($apiUrlColor, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $resultColor = json_decode($responseColor->getBody(), true);

            // Fetch Brand data
            $responseBrand = $client->get($apiUrlBrand, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $resultBrand = json_decode($responseBrand->getBody(), true);

            $user = Auth::user();

            if ($user) {
                // Retrieve all data for the user from the database
                $userData = User::where('id', $user->id)->first();

                $notifications = Notification::where('username', $user->username)->get();

                // Pass both results to the view
                return view('users-layout.dashboard.insurance', [
                    'userData'      => $userData,
                    'notifications' => $notifications,
                ], compact('resulthealth_insurance', 'resultui_insure', 'resultState', 'resultColor', 'resultBrand'));
            }
        } catch (\Exception $e) {
            // Handle any errors that may occur during the API request
            return back()->with('error', 'Failed to retrieve data from the API: ' . $e->getMessage());
        }
    }
    public function ui_insure(Request $request)
    {
        // Validate the request
        $request->validate([
            'ui_insure'       => 'required|string',
            'state'           => 'required|string',
            'lga'             => 'required|string',
            'VehicleMakeCode' => 'required|string',
            'model'           => 'required|string',
            'VehicleColor'    => 'required|string',
            'EngineCapacity'  => 'required|string',
            'InsuredName'     => 'required|string',
            'ChassisNumber'   => 'required|string',
            'PlateNumber'     => 'required|string',
            'YearofMake'      => 'required|string',
            'EmailAddress'    => 'required|email',
            'phoneNumber'     => 'required|string',
            'amount'          => 'required|string',
        ]);

                                                          // Process the form data
        $serviceID      = 'ui-insure';                    // Service ID for UI Insurance
        $billcode       = $request->input('PlateNumber'); // Plate Number as billersCode
        $phoneNumber    = $request->input('phoneNumber');
        $amount         = $request->input('amount');
        $variation_code = $request->input('ui_insure'); // Insurance type variation code
        $insuredName    = $request->input('InsuredName');
        $engineCapacity = $request->input('EngineCapacity');
        $chassisNumber  = $request->input('ChassisNumber');
        $vehicleMake    = $request->input('VehicleMakeCode');
        $vehicleColor   = $request->input('VehicleColor');
        $vehicleModel   = $request->input('model');
        $yearOfMake     = $request->input('YearofMake');
        $state          = $request->input('state');
        $lga            = $request->input('lga');
        $email          = $request->input('EmailAddress');

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User roles
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'ui-insure' => 'Third_Party_Motor_Insurance_-_Universal_Insurance',
        ];

        // Initialize finalAmount and profit
        $finalAmount       = $amount;
        $fixedProfitAmount = 0;

        // Check if service exists in the map
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            if ($percentage) {
                // Determine the percentage based on the user role
                if ($smart_earners == 1) {
                    $profitPercentage = $percentage->smart_earners_percent;
                } elseif ($topuser_earners == 1) {
                    $profitPercentage = $percentage->topuser_earners_percent;
                } elseif ($api_earners == 1) {
                    $profitPercentage = $percentage->api_earners_percent;
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }

                // Calculate the profit and final amount
                $fixedProfitAmount = ($profitPercentage / 100) * $amount;
                $finalAmount       = $amount - $fixedProfitAmount;
                $finalAmount       = ceil($finalAmount);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected service']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Get the current timestamp
        $current_time   = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");

        // Generate a unique request ID
        $additional_chars = bin2hex(random_bytes(4));
        $request_id       = $formatted_time . $additional_chars;

        // Retrieve API configuration settings
        $configuration = Setting::first();

        // Set up Guzzle client
        $client = new Client();
        $apiUrl = $configuration->airtime_api_url;

        // Set up API request data
        $data = [
            "request_id"      => $request_id,
            "serviceID"       => $serviceID,
            "variation_code"  => $variation_code,
            "amount"          => $amount,
            "billersCode"     => $billcode,
            "phone"           => $phoneNumber,
            "Insured_Name"    => $insuredName,
            "engine_capacity" => $engineCapacity,
            "Chasis_Number"   => $chassisNumber,
            "Plate_Number"    => $billcode,
            "vehicle_make"    => $vehicleMake,
            "vehicle_color"   => $vehicleColor,
            "vehicle_model"   => $vehicleModel,
            "YearofMake"      => $yearOfMake,
            "state"           => $state,
            "lga"             => $lga,
            "email"           => $email,
        ];

        try {
            // Send POST request to VTpass API
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Check if the transaction was successful
            if (isset($result['code']) && $result['code'] === '000') {
                // Deduct the amount from the user's balance
                User::where('id', $user->id)->update(['account_balance' => $userBalance - $finalAmount]);

                // Insert the transaction data into the insurance_transactions table
                InsuranceTransaction::create([
                    'username'             => $user->username,
                    'product_name'         => 'Third Party Motor Insurance - Universal Insurance',
                    'type'                 => $variation_code,
                    'tel'                  => $phoneNumber,
                    'amount'               => $amount,
                    'reference'            => $result['requestId'],
                    'purchased_code'       => $result['purchased_code'] ?? null,
                    'response_description' => $result['response_description'] ?? 'No description provided',
                    'transaction_date'     => now(),
                    'identity'             => 'Third Party Motor Insurance',
                    'prev_bal'             => $userBalance,
                    'current_bal'          => $userBalance - $finalAmount,
                    'percent_profit'       => $fixedProfitAmount, // Save the calculated profit amount
                    'status'               => 'successful',
                ]);

                // Return the result
                return response()->json(['result' => $result]);
            } else {
                return response()->json(['status' => 'failed', 'message' => $result['response_description']]);
            }
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function healthInsurance(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'healthInsurancePlan' => 'required|string',
            'fullName'            => 'required|string',
            'dob'                 => 'required|date',
            'contactAddress'      => 'required|string',
            'nextOfKinName'       => 'required|string',
            'nextOfKinPhone'      => 'required|string',
            'businessOccupation'  => 'required|string',
            'phoneNumber2'        => 'required|string',
            'emailAddress2'       => 'required|email',
            'amount2'             => 'required|numeric',
        ]);

                                                                      // Process the form data
        $serviceID          = 'personal-accident-insurance';          // Service ID for Health Insurance
        $variation_code     = $request->input('healthInsurancePlan'); // Health Insurance Plan variation code
        $fullName           = $request->input('fullName');
        $dob                = $request->input('dob');
        $contactAddress     = $request->input('contactAddress');
        $nextOfKinName      = $request->input('nextOfKinName');
        $nextOfKinPhone     = $request->input('nextOfKinPhone');
        $businessOccupation = $request->input('businessOccupation');
        $phoneNumber        = $request->input('phoneNumber2');
        $email              = $request->input('emailAddress2');
        $amount             = $request->input('amount2');

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User roles
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            'personal-accident-insurance' => 'Personal_Accident_Insurance',
        ];

        // Initialize finalAmount and profit
        $finalAmount       = $amount;
        $fixedProfitAmount = 0;

        // Check if service exists in the map
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage  = Percentage::where('service', $serviceName)->first();

            if ($percentage) {
                // Determine the percentage based on the user role
                if ($smart_earners == 1) {
                    $profitPercentage = $percentage->smart_earners_percent;
                } elseif ($topuser_earners == 1) {
                    $profitPercentage = $percentage->topuser_earners_percent;
                } elseif ($api_earners == 1) {
                    $profitPercentage = $percentage->api_earners_percent;
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }

                // Calculate profit
                $fixedProfitAmount = ($amount * $profitPercentage) / 100;
                $finalAmount       = $amount - $fixedProfitAmount;
                $finalAmount       = ceil($finalAmount);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Service percentage not found']);
            }
        }

        // Get the current timestamp and unique request ID
        $current_time     = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time   = $current_time->format("YmdHis");
        $additional_chars = bin2hex(random_bytes(4));
        $request_id       = $formatted_time . $additional_chars;

        // Retrieve API settings
        $configuration = Setting::first();
        $apiUrl        = $configuration->airtime_api_url;

        // Set up API request data
        $data = [
            "request_id"          => $request_id,
            "serviceID"           => $serviceID,
            "variation_code"      => $variation_code,
            "amount"              => $finalAmount, // Use the finalAmount with profit deducted
            "billersCode"         => $fullName,
            "phone"               => $phoneNumber,
            "full_name"           => $fullName,
            "address"             => $contactAddress,
            "dob"                 => $dob,
            "next_kin_name"       => $nextOfKinName,
            "next_kin_phone"      => $nextOfKinPhone,
            "business_occupation" => $businessOccupation,
        ];

        try {
            // Set up Guzzle client
            $client = new Client();

            // Send POST request to VTpass API
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Check if the transaction was successful
            if (isset($result['code']) && $result['code'] === '000') {
                // Deduct the final amount from the user's balance
                User::where('id', $user->id)->update(['account_balance' => $userBalance - $finalAmount]);

                // Insert the transaction data into the insurance_transactions table
                InsuranceTransaction::create([
                    'username'             => $user->username,
                    'product_name'         => 'Personal Accident Insurance',
                    'type'                 => $variation_code,
                    'tel'                  => $phoneNumber,
                    'amount'               => $finalAmount, // Save final amount
                    'reference'            => $result['requestId'],
                    'purchased_code'       => $fullName,
                    'response_description' => $result['response_description'] ?? 'No description provided',
                    'transaction_date'     => now(),
                    'identity'             => 'Health Insurance',
                    'prev_bal'             => $userBalance,
                    'current_bal'          => $userBalance - $finalAmount,
                    'percent_profit'       => $fixedProfitAmount,
                    'status'               => 'successful',
                ]);

                // Return the result
                return response()->json(['result' => $result]);
            } else {
                return response()->json(['status' => 'failed', 'message' => $result['response_description']]);
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Return an error response with exception details
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Error during API request',
                'exception' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Catch any other exceptions
            return response()->json([
                'status'    => 'failed',
                'message'   => 'An unexpected error occurred',
                'exception' => $e->getMessage(),
            ]);
        }
    }

    public function upgradeTopuser(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'upgrade_type' => 'required|string',
            'amount'       => 'required|numeric',
        ]);

        $upgrade_type = $request->input('upgrade_type');
        $amount       = $request->input('amount');

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // Check if the user has sufficient balance
        if ($userBalance >= $amount) {
            // Calculate the new balance
            $newBalance = $userBalance - $amount;

            // Update the user's balance and upgrade the account
            User::where('id', $user->id)->update([
                'account_balance' => $newBalance,
                'topuser_earners' => 1,
                'smart_earners'   => 0,
                'api_earners'     => 0,
            ]);

            // Check if the user was referred by another user
            if ($user->refferal_user) {
                $referrer = User::where('user_id', $user->refferal_user)->first();

                if ($referrer) {
                    // Add 500 to the referrer's balance
                    $referrer->increment('account_balance', 500);
                    $referrer->increment('refferal_bonus', 500);

                    // Optionally, create a record of this referral reward
                    // Referral::create([
                    //     'user_id' => $referrer->user_id,  // Referrer's ID
                    //     'referral_user_id' => $user->user_id, // Upgraded user's ID
                    //     'referral_username' => $user->username, // Upgraded user's username
                    //     'reward_amount' => 500, // Amount rewarded
                    // ]);
                }
            }

            // Return a success response
            return response()->json([
                'status'  => 'success',
                'message' => 'Your account has been upgraded to Topuser. Referral reward added if applicable.',
            ], 200);
        } else {
            // If balance is insufficient, return an error response
            return response()->json([
                'status'  => 'error',
                'message' => 'Insufficient balance. Please top up your account.',
            ], 400);
        }
    }

    // public function topUp(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         '_token' => 'required', // Ensure CSRF token is present
    //         'userId' => 'required|exists:users,id', // Validate userId if needed
    //     ]);

    //     // Process the top-up logic here (e.g., updating user account)

    //     return response()->json(['message' => 'Upgrade successful!'], 200);
    // }
}
