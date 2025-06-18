<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TvTransactions;  // Import the TvTransactions model
use App\Models\dataTransactions;  // Import the TvTransactions model
use App\Models\AirtimeTransaction;  // Import the TvTransactions model
use App\Models\EletricityTransaction;  // Import the TvTransactions model
use App\Models\EducationTransaction;  // Import the TvTransactions model
use App\Models\InsuranceTransaction;  // Import the TvTransactions model
use App\Models\Notification;  // Import the TvTransactions model
use App\Models\Setting;  // Import the TvTransactions model
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FundTransaction;

class transactionController extends Controller
{
    public function indexAction(Request $request)
    {
        // Retrieve the requestId from the query parameters
        $requestId = $request->query('hash');

        // Attempt to find the transaction in the TvTransactions table
        $transaction = TvTransactions::where('transaction_id', $requestId)->first();

        // Check if the transaction was found
        if (!$transaction) {
            $transaction = dataTransactions::where('transaction_id', $requestId)->first();
        }

        if (!$transaction) {
            $transaction = AirtimeTransaction::where('transaction_id', $requestId)->first();
        }

        if (!$transaction) {
            $transaction = EletricityTransaction::where('transaction_id', $requestId)->first();
        }

        if (!$transaction) {
            $transaction = InsuranceTransaction::where('transaction_id', $requestId)->first();
        }

        if (!$transaction) {
            $transaction = EducationTransaction::where('transaction_id', $requestId)->first();
        }

        if (!$transaction) {
            $transaction = FundTransaction::where('transaction_id', $requestId)->first();
        }
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();

            // Pass the transaction details to the transaction view
            return view('users-layout.dashboard.transactionview', [
                'userData' => $userData,
                'notifications' => $notifications,
            ], [
                'transaction' => $transaction,
            ]);
        }
    }
    public function usertransactions()
    {


        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();

            $notifications = Notification::where('username', $user->username)->get();

            // Pass the data and the flag to the view
            return view('users-layout.dashboard.transactions', [
                'userData' => $userData,
                'notifications' => $notifications,
            ]);
        }
    }

    public function fetchAirtimeTransactions()
    {
        $user = Auth::user();
        $transactions = AirtimeTransaction::where('username', $user->username)
        ->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
    
        return response()->json($transactions);
    }

    public function fetchDataTransactions()
    {
        $user = Auth::user();
        $dataTransactions = dataTransactions::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
        return response()->json($dataTransactions);
    }

    public function fetchElectricityTransactions()
    {
        $user = Auth::user();
        $electricityTransactions = EletricityTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
        return response()->json($electricityTransactions);
    }

    public function fetchTvTransactions()
    {
        $user = Auth::user();
        $tvTransactions = TvTransactions::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
        return response()->json($tvTransactions);
    }

    public function fetchEducationTransactions()
    {
        $user = Auth::user();
        $educationTransactions = EducationTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
        return response()->json($educationTransactions);
    }

    public function fetchInsuranceTransactions()
    {
        $user = Auth::user();
        $insuranceTransactions = InsuranceTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
        return response()->json($insuranceTransactions);
    }
    public function fetchFundTransactions()
    {
        $user = Auth::user();
        $fundTransactions = FundTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
        ->get();
        return response()->json($fundTransactions);
    }


    public function usernotification()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();

            // Fetch notifications where the username matches the authenticated user's username
            $notifications = Notification::where('username', $user->username)->get();

            return view('users-layout.dashboard.notification', [
                'userData' => $userData,
                'notifications' => $notifications,
            ]);
        }

        // Handle the case where the user is not authenticated
        return redirect()->route('login')->with('error', 'Please log in to view your notifications.');
    }

    public function walletSummary()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $username = $user->username;

        // Fetch data from each table where username matches the authenticated user
        $airtimeTransactions = AirtimeTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $dataTransactions = dataTransactions::where('username', $username)->orderBy('created_at', 'desc')->get();
        $educationTransactions = EducationTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $electricityTransactions = EletricityTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $fundTransactions = FundTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $insuranceTransactions = InsuranceTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $tvTransactions = TvTransactions::where('username', $username)->orderBy('created_at', 'desc')->get();

        // Combine the transactions into a single collection and sort them by creation date
        $allTransactions = $airtimeTransactions
            ->merge($dataTransactions)
            ->merge($educationTransactions)
            ->merge($electricityTransactions)
            ->merge($fundTransactions)
            ->merge($insuranceTransactions)
            ->merge($tvTransactions)
            ->sortByDesc('created_at'); // Sort by creation date in descending order

        // Fetch user data
        $userData = User::where('id', $user->id)->first();

        // Fetch notifications where the username matches the authenticated user's username
        $notifications = Notification::where('username', $username)->get();
        $configuration= Setting::first();
        // Pass the data to the view
        return view('users-layout.dashboard.wallet', compact('userData', 'notifications', 'allTransactions','configuration'));
    }
}
