<?php
namespace App\Http\Controllers;

use App\Models\dataTransactions;
use App\Models\Notification;
use App\Models\percentage;
use App\Models\Setting;
use App\Models\User;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class dataController extends Controller
{
    public function indexAction()
    {

        $configuration = Setting::first();
        // API URL and key
        $api_url = "https://lucysrosedata.com/api/network/";
        $api_key = "Token " . $configuration->site_token;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $api_key",
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Handle errors
        if (curl_errno($ch)) {
            $error_msg = 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => $error_msg], 500);
        }

        // Get HTTP response code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($ch);

        // Handle the response
        if ($http_code == 200) {
            // Decode JSON response
            $data = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data_type = ['SME', 'SME 2', 'GIFTING', 'CORPORATE GIFTING'];
                $user      = Auth::user();

                if ($user) {
                    // Retrieve all data for the user from the database
                    $userData      = User::where('id', $user->id)->first();
                    $notifications = Notification::where('username', $user->username)->get();

                    // Define the service types
                    $services = [
                        '9mobile_GIFTING_Data',
                        'GLO_GIFTING_Data',
                        'GLO_CORPORATE_GIFTING_Data',
                        'MTN_SME_Data',
                        'MTN_SME2_Data',
                        'Airtel_CORPORATE_GIFTING_Data',
                        'MTN_CORPORATE_GIFTING_Data',
                        '9mobile_CORPORATE_GIFTING_Data',
                    ];

                    // Determine the user's upgraded account type
                    $userAccountType = null;
                    if ($user->smart_earners == 1) {
                        $userAccountType = 'smart_earners_percent';
                    } elseif ($user->topuser_earners == 1) {
                        $userAccountType = 'topuser_earners_percent';
                    } elseif ($user->api_earners == 1) {
                        $userAccountType = 'api_earners_percent';
                    }

                    // Fetch the percentages based on the user's account type
                    $percentages = [];
                    if ($userAccountType) {
                        $percentages = Percentage::whereIn('service', $services)
                            ->select('service', $userAccountType . ' as percent')
                            ->get();
                    }

                    return view('users-layout.dashboard.data', [
                        'networks'      => $data,
                        'data_type'     => $data_type,
                        'userData'      => $userData,
                        'notifications' => $notifications,
                        'percentages'   => $percentages, // Pass the percentages to the view
                    ]);
                }
            } else {
                $json_error = 'JSON decode error: ' . json_last_error_msg();
                return response()->json(['error' => $json_error], 500);
            }
        } else {
            $http_error = "HTTP request failed with code $http_code. Response: $response";
            return response()->json(['error' => $http_error], $http_code);
        }
    }

    public function purchaseData(Request $request)
    {
        // Validate the request
        $request->validate([
            'network'     => 'required|in:1,2,4,6',
            'networkType' => 'required',
            'amount'      => 'required|numeric',
            'tel'         => 'required|numeric',
            'type'        => 'required',
        ]);

        // Get the input values
        $network     = $request->input('network');
        $amount      = $request->input('amount');
        $tel         = $request->input('tel');
        $networkType = $request->input('networkType');
        $plan        = $request->input('type');

        // Retrieve the authenticated user
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Define the service map using network and networkType
        $serviceMap = [
            4 => [
                'CORPORATE GIFTING' => 'Airtel_CORPORATE_GIFTING_Data',
                'GIFTING'           => 'Airtel_GIFTING_Data',
            ],
            1 => [
                'SME'               => 'MTN_SME_Data',
                'SME 2'             => 'MTN_SME2_Data',
                'CORPORATE GIFTING' => 'MTN_CORPORATE_GIFTING_Data',
                'GIFTING'           => 'MTN_GIFTING_Data',
            ],
            2 => [
                'GIFTING'           => 'GLO_GIFTING_Data',
                'CORPORATE GIFTING' => 'GLO_CORPORATE_GIFTING_Data',
            ],
            6 => [
                'GIFTING'           => '9mobile_GIFTING_Data',
                'CORPORATE GIFTING' => '9mobile_CORPORATE_GIFTING_Data',
            ],
        ];

        // Ensure both network and networkType are mapped
        if (! isset($serviceMap[$network][$networkType])) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid network or network type']);
        }

        // Get the service type from the map
        $service = $serviceMap[$network][$networkType];

        // Fetch the percentage for the selected service from the database
        $percentage = Percentage::where('service', $service)->first();

        // Check if percentage data exists
        if (! $percentage) {
            return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected network and type']);
        }

        // Calculate the final amount based on the user's type
        if ($smart_earners) {
            $deduction = ($percentage->smart_earners_percent / 100) * $amount;
        } elseif ($topuser_earners) {
            $deduction = ($percentage->topuser_earners_percent / 100) * $amount;
        } elseif ($api_earners) {
            $deduction = ($percentage->api_earners_percent / 100) * $amount;
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid user type']);
        }

        $finalAmount    = ceil($amount); // Use ceil() to round up
        $percent_profit = $deduction;

        // Check if the user has sufficient funds
        if ($userBalance < $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient funds']);
        }

        // Calculate the current balance after the deduction
        $currentBal = $userBalance - $finalAmount;

        // Generate a unique request ID
        $current_time     = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time   = $current_time->format("YmdHis");
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }

        $configuration = Setting::first();
        // API URL and key
        $api_url = "https://lucysrosedata.com/api/network/";
        $api_key = "Token " . $configuration->site_token;

        // Set up API request data
        $data = [
            "network"       => $network,
            "mobile_number" => $tel,
            "plan"          => $plan,
            "Ported_number" => true, // Assuming this is a required parameter
        ];

        // Initialize GuzzleHttp client
        $client = new \GuzzleHttp\Client();

        try {
            // Make the API request
            $response = $client->post($api_url, [
                'headers' => [
                    'Authorization' => $api_key,
                    'Content-Type'  => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody(), true);

            // Check if the transaction failed in the API response
            if (isset($result['Status']) && strtolower($result['Status']) === 'failed') {
                // Return an error response if the API status is failed
                return response()->json(['status' => 'failed', 'message' => 'Data purchase failed', 'result' => $result]);
            }

            // If successful, deduct the final amount from the user's balance
            User::where('id', $user->id)->update(['account_balance' => $currentBal]);

            // Store the transaction in the database with new fields
            DataTransactions::create([
                'username'       => $user->username,
                'api_response'   => $result['api_response'],
                'network'        => $network,
                'tel'            => $tel,
                'plan'           => $result['plan_name'],
                'amount'         => $finalAmount,
                'prev_bal'       => $userBalance,
                'current_bal'    => $currentBal,
                'percent_profit' => $percent_profit,
                'reference'      => $result['ident'],
                'identity'       => 'Data Purchase',
                'status'         => 'successful',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // Return a success response
            return response()->json(['status' => 'delivered', 'message' => 'Data purchase successful', 'result' => $result]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle Guzzle request exception
            return response()->json(['status' => 'failed', 'message' => 'HTTP request error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json(['status' => 'failed', 'message' => 'General error: ' . $e->getMessage()], 500);
        }
    }

    public function getNetworkPlans(Request $request)
    {
        $configuration = Setting::first();
        // API URL and key
        $api_url = "https://lucysrosedata.com/api/network/";
        $api_key = "Token " . $configuration->site_token;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $api_key",
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Handle errors
        if (curl_errno($ch)) {
            $error_msg = 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => $error_msg], 500);
        }

        // Get HTTP response code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($ch);

        // Check for successful response
        if ($http_code != 200) {
            return response()->json(['error' => 'Failed to fetch network plans.'], $http_code);
        }

        // Decode the JSON response
        $decoded_response = json_decode($response, true);

        // Handle JSON decode errors
        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->json(['error' => 'Failed to decode JSON response.'], 500);
        }

        // Return the decoded response
        return response()->json($decoded_response);
    }

    public function dataPurchaseMtnAirtelGifting(Request $request)
    {
        // Validate the request
        $request->validate([
            'network' => 'required|in:1,2,4,6',
            'type'    => 'required',
            'tel'     => 'required|numeric',
            'amount'  => 'required|numeric',
        ]);

        // Get the input values
        $isnetwork = $request->input('network');
        $network   = null;

        // Fix the network logic
        if ($isnetwork == 4) {
            $network = "airtel";
        } elseif ($isnetwork == 1) {
            $network = "mtn";
        }

        if ($network === null) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid network selected']);
        }

        $type = $request->input('type');
        $tel  = $request->input('tel');

        // Extract the last part of the string after the hyphen
        $parts  = explode('-', $type);
        $amount = end($parts); // Get the last part of the array

        // Optionally, ensure $amount is numeric
        if (! is_numeric($amount)) {
            return response()->json(['error' => 'Invalid amount format'], 400);
        }
        // dd($amount);
        // Retrieve the authenticated user and balance
        $user        = Auth::user();
        $userBalance = $user->account_balance;

        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Define the service map for Airtel and MTN
        $serviceMap = [
            'airtel' => 'Airtel_GIFTING_Data',
            'mtn'    => 'MTN_GIFTING_Data',
        ];
        $serviceID = $network . "-data";
        $service   = $serviceMap[$network] ?? null;

        // Fetch percentage based on user type and service
        $percentage = Percentage::where('service', $service)->first();

        if (! $percentage) {
            return response()->json(['status' => 'failed', 'message' => 'Percentage data not found for this service']);
        }

        // Calculate the deduction based on user type
        if ($smart_earners) {
            $deduction = ($percentage->smart_earners_percent / 100) * $amount;
        } elseif ($topuser_earners) {
            $deduction = ($percentage->topuser_earners_percent / 100) * $amount;
        } elseif ($api_earners) {
            $deduction = ($percentage->api_earners_percent / 100) * $amount;
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid user type']);
        }

        $finalAmount    = ceil($amount); // Use ceil() to round up
        $percent_profit = $deduction;

        // Check if the user has sufficient funds
        if ($userBalance < $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient funds']);
        }

        // Calculate the current balance after deduction
        $currentBal = $userBalance - $finalAmount;

        // Generate a unique request ID
        $current_time     = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time   = $current_time->format("YmdHis");
        $additional_chars = "89htyyo";
        $request_id       = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }

        // Fetch the API configuration
        $configuration = Setting::first();
        $apiUrl        = $configuration->airtime_api_url;

        // Set up API request data
        $data = [
            "request_id"     => $request_id,
            "serviceID"      => $serviceID,
            "billersCode"    => $tel,
            "variation_code" => $type,
            "amount"         => $amount,
            "phone"          => $tel,
        ];

        try {
            // Make the API request using Guzzle
            $client   = new Client();
            $response = $client->post($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json'    => $data,
            ]);

            // Decode the response
            $result = json_decode($response->getBody());

            // Check if the transaction was successful
            if (isset($result->content->transactions->status) && $result->content->transactions->status === "delivered") {
                // Deduct the final amount from the user's balance
                User::where('id', $user->id)->update(['account_balance' => $currentBal]);

                // Store the transaction in the database
                DataTransactions::create([
                    'username'       => $user->username,
                    'api_response'   => $result->content->transactions->product_name,
                    'network'        => $network,
                    'tel'            => $tel,
                    'plan'           => $result->content->transactions->product_name, // Assuming this field represents the plan
                    'amount'         => $finalAmount,
                    'reference'      => $result->content->transactions->transactionId,
                    'identity'       => 'Data Purchase',
                    'prev_bal'       => $userBalance,
                    'current_bal'    => $currentBal,
                    'percent_profit' => $percent_profit,
                    'status'         => 'successful',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                // Return a success response
                return response()->json(['status' => 'delivered', 'message' => 'Data purchase successful', 'result' => $result]);
            } else {
                // Return an error response if the transaction failed
                return response()->json(['status' => 'failed', 'message' => 'Data purchase failed', 'result' => $result]);
            }
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => 'Error during API request', 'exception' => $e->getMessage()]);
        }
    }

    public function dataMtnAirtelGifting(Request $request)
    {
        $configuration = Setting::first();
        if (! $configuration) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Configuration not found',
            ]);
        }

        $network = $request->input('network');

        // Validate the network input
        if (! in_array($network, [1, 4])) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Invalid network selected',
            ]);
        }

        // Determine API URL
        $apiUrl = ($network == 1) ? $configuration->data_mtn : $configuration->data_airtime;

        // Retrieve the authenticated user
        $user            = Auth::user();
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        // Map service IDs to service names
        $serviceMap = [
            4 => 'Airtel_GIFTING_Data',
            1 => 'MTN_GIFTING_Data',
        ];

        // Check if the selected network exists in the service map
        $serviceName = $serviceMap[$network] ?? null;
        if (! $serviceName) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Invalid service mapping',
            ]);
        }

        // Fetch percentage settings for the service
        $percentage = Percentage::where('service', $serviceName)->first();
        if (! $percentage) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Service percentage not found',
            ]);
        }

        // Determine the profit percentage based on the user role
        if ($smart_earners) {
            $profitPercentage = $percentage->smart_earners_percent;
        } elseif ($topuser_earners) {
            $profitPercentage = $percentage->topuser_earners_percent;
        } elseif ($api_earners) {
            $profitPercentage = $percentage->api_earners_percent;
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'No valid earner type found',
            ]);
        }

        try {
            // Make the API request
            $client   = new Client();
            $response = $client->get($apiUrl, [
                'headers' => [
                    'api-key'      => $configuration->api_key,
                    'secret-key'   => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);

            // Decode the API response
            $result = json_decode($response->getBody(), true);

            if (! empty($result)) {
                return response()->json([
                    'status'           => 'success',
                    'data'             => $result,
                    'profitPercentage' => $profitPercentage,
                ]);
            } else {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'No data variations available',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Error fetching data variations',
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
