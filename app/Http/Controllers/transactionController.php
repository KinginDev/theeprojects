<?php
namespace App\Http\Controllers;

use App\Models\AirtimeTransaction;
use App\Models\DataTransaction;        // Import the TvTransaction model
use App\Models\EducationTransaction;   // Import the TvTransaction model
use App\Models\ElectricityTransaction; // Import the TvTransaction model
use App\Models\FundTransaction;        // Import the TvTransaction model
use App\Models\InsuranceTransaction;   // Import the TvTransaction model
use App\Models\Notification;           // Import the TvTransaction model
use App\Models\Setting;                // Import the TvTransaction model
use App\Models\TvTransaction;          // Import the TvTransaction model
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class transactionController extends Controller
{
    public function indexAction(Request $request)
    {
        // Retrieve the requestId from the query parameters
        $requestId = $request->query('hash');

        // Attempt to find the transaction in the TvTransaction table
        $transaction = TvTransaction::where('reference', $requestId)->first();

        // Check if the transaction was found
        if (! $transaction) {
            $transaction = DataTransaction::where('reference', $requestId)->first();
        }

        if (! $transaction) {
            $transaction = AirtimeTransaction::where('reference', $requestId)->first();
        }

        if (! $transaction) {
            $transaction = ElectricityTransaction::where('reference', $requestId)->first();
        }

        if (! $transaction) {
            $transaction = InsuranceTransaction::where('reference', $requestId)->first();
        }

        if (! $transaction) {
            $transaction = EducationTransaction::where('reference', $requestId)->first();
        }

        if (! $transaction) {
            $transaction = FundTransaction::where('reference', $requestId)->first();
        }
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData      = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();

            // Pass the transaction details to the transaction view
            return view('users-layout.dashboard.transactionview', [
                'userData'      => $userData,
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
                'userData'      => $userData,
                'notifications' => $notifications,
            ]);
        }
    }

    public function fetchAirtimeTransactions()
    {
        $user         = Auth::user();
        $transactions = AirtimeTransaction::where('username', $user->username)
            ->orderBy('created_at', 'desc') // or 'transaction_date'
            ->get();

        return response()->json($transactions);
    }

    public function fetchDataTransaction()
    {
        $user            = Auth::user();
        $DataTransaction = DataTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
            ->get();
        return response()->json($DataTransaction);
    }

    public function fetchElectricityTransactions()
    {
        $user                    = Auth::user();
        $electricityTransactions = ElectricityTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
            ->get();
        return response()->json($electricityTransactions);
    }

    public function fetchTvTransaction()
    {
        $user           = Auth::user();
        $tvTransactions = TvTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
            ->get();
        return response()->json($tvTransactions);
    }

    public function fetchEducationTransactions()
    {
        $user                  = Auth::user();
        $educationTransactions = EducationTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
            ->get();
        return response()->json($educationTransactions);
    }

    public function fetchInsuranceTransactions()
    {
        $user                  = Auth::user();
        $insuranceTransactions = InsuranceTransaction::where('username', $user->username)->orderBy('created_at', 'desc') // or 'transaction_date'
            ->get();
        return response()->json($insuranceTransactions);
    }
    public function fetchFundTransactions()
    {
        $user             = Auth::user();
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
                'userData'      => $userData,
                'notifications' => $notifications,
            ]);
        }

        // Handle the case where the user is not authenticated
        return redirect()->route('login')->with('error', 'Please log in to view your notifications.');
    }

    public function walletSummary()
    {
        // Retrieve the authenticated user
        $user     = Auth::user();
        $username = $user->username;

        // Fetch data from each table where username matches the authenticated user
        $airtimeTransactions     = AirtimeTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $DataTransaction         = DataTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $educationTransactions   = EducationTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $electricityTransactions = ElectricityTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $fundTransactions        = FundTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $insuranceTransactions   = InsuranceTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();
        $tvTransactions          = TvTransaction::where('username', $username)->orderBy('created_at', 'desc')->get();

        // Combine the transactions into a single collection and sort them by creation date
        $allTransactions = $airtimeTransactions
            ->merge($DataTransaction)
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
        $configuration = Setting::first();
        // Pass the data to the view
        return view('users-layout.dashboard.wallet', compact('userData', 'notifications', 'allTransactions', 'configuration'));
    }
}
