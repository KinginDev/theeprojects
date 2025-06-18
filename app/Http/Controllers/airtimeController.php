<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\AirtimeTransaction;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\percentage;

class airtimeController extends Controller
{
    public function indexAction()
    {

        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();

            return view('users-layout.dashboard.airtime', [
                'userData' => $userData,
                'notifications' => $notifications,
            ],);
        }
    }

    public function purchaseAirtime(Request $request)
    {
        // Validate the request
        $request->validate([
            'network' => 'required|in:mtn,airtel,glo,etisalat', // Validate that network is one of the specified values
            'amount' => 'required|numeric',
            'tel' => 'required|numeric',
        ]);

        // Get the input values
        $network = $request->input('network');
        $amount = $request->input('amount');
        $tel = $request->input('tel');

        // Retrieve the authenticated user
        $user = Auth::user();
        $userBalance = $user->account_balance;
        $email = $user->email;
        $username = $user->username;

        // User types
        $smart_earners = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners = $user->api_earners;

        // Get percentage rates for services
        $getPercentage = Percentage::select('smart_earners_percent', 'topuser_earners_percent', 'api_earners_percent')
            ->whereIn('service', [
                'Airtel_Airtime_VTU',
                'GLO_Airtime_VTU',
                'MTN_Airtime_VTU',
                '9mobile_Airtime_VTU'
            ])->get();

        // Check if the user has sufficient funds
        if ($userBalance < $amount) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient funds']);
        }

        // Convert the network to lowercase to match the service ID
        $serviceID = strtolower($network);

        // Map service IDs to the corresponding service names in the database
        $serviceMap = [
            'airtel' => 'Airtel_Airtime_VTU',
            'mtn' => 'MTN_Airtime_VTU',
            'glo' => 'GLO_Airtime_VTU',
            'etisalat' => '9mobile_Airtime_VTU' // Etisalat now called 9mobile
        ];

        // Initialize finalAmount with the original amount
        $finalAmount = $amount;

        // Apply the correct deduction based on the user's role
        if (isset($serviceMap[$serviceID])) {
            $serviceName = $serviceMap[$serviceID];
            $percentage = Percentage::where('service', $serviceMap[$serviceID])->first();

            if ($percentage) {
                if ($smart_earners == 1) {
                    $smartEarnerPercent = $percentage->smart_earners_percent;
                    $deduction = ($smartEarnerPercent / 100) * $amount;
                    $finalAmount = $amount - $deduction;
                } elseif ($topuser_earners == 1) {
                    $topuserEarnerPercent = $percentage->topuser_earners_percent;
                    $deduction = ($topuserEarnerPercent / 100) * $amount;
                    $finalAmount = $amount - $deduction;
                } elseif ($api_earners == 1) {
                    $apiEarnerPercent = $percentage->api_earners_percent;
                    $deduction = ($apiEarnerPercent / 100) * $amount;
                    $finalAmount = $amount - $deduction;
                } else {
                    return response()->json(['status' => 'failed', 'message' => 'No valid earner type found']);
                }

                // Round up the final amount to the nearest whole number
                $finalAmount = ceil($finalAmount);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'No percentage data found for the selected network']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Invalid service ID']);
        }

        // Generate request ID
        $current_time = new DateTime('now', new DateTimeZone('Africa/Lagos'));
        $formatted_time = $current_time->format("YmdHis");
        $additional_chars = "89htyyo";
        $request_id = $formatted_time . $additional_chars;
        while (strlen($request_id) < 12) {
            $request_id .= "x";
        }

        // Get settings
        $configuration = Setting::first();
        $apiUrl = $configuration->airtime_api_url;

        // Set up Guzzle client and API request
        $client = new Client();
        $data = [
            "request_id" => $request_id,
            "serviceID" => $serviceID,
            "amount" => $amount, // Use finalAmount after deduction and rounding
            "phone" => $tel,
            "email" => $email,
        ];

        // Make API call
        $response = $client->post($apiUrl, [
            'headers' => [
                'api-key' => $configuration->api_key,
                'secret-key' => $configuration->secret_key,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        // Decode the API response
        $result = json_decode($response->getBody());

        // Check if the transaction was successful
        if (isset($result->content->transactions->status) && $result->content->transactions->status === "delivered") {
            // Deduct finalAmount from user balance
            User::where('id', $user->id)->update(['account_balance' => $userBalance - $finalAmount]);
            $currentBal = $userBalance - $finalAmount;

            // Requery the transaction status using the request_id
            $requeryUrl = $configuration->transaction_api_url;
            $requeryResponse = $client->post($requeryUrl, [
                'headers' => [
                    'api-key' => $configuration->api_key,
                    'secret-key' => $configuration->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => ['request_id' => $request_id],
            ]);

            $requeryResult = json_decode($requeryResponse->getBody());

            // Check if the requery was successful
            if ($requeryResult->code === "000") {
                // Save transaction in the database
                $transaction = new AirtimeTransaction();
                $transaction->username = $username;
                $transaction->network = $network;
                $transaction->tel = $tel;
                $transaction->amount = $amount;
                $transaction->prev_bal = $userBalance;
                $transaction->current_bal = $currentBal;
                $transaction->percent_profit = $amount - $finalAmount;
                $transaction->transaction_id = $requeryResult->content->transactions->transactionId;
                $transaction->identity = $requeryResult->content->transactions->unique_element;
                $transaction->status = $requeryResult->content->transactions->status;
                $transaction->created_at = now();
                $transaction->updated_at = now();
                $transaction->save();

                // Return success response
                return response()->json(['status' => 'delivered', 'message' => 'Airtime purchase successful', 'result' => $result]);
            } else {
                // Return requery error
                return response()->json(['status' => 'failed', 'message' => 'Failed to verify transaction status', 'result' => $requeryResult]);
            }
        } else {
            // Return purchase failure
            return response()->json(['status' => 'failed', 'message' => 'Airtime purchase failed', 'result' => $result]);
        }
    }
}
