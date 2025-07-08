<?php
namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Models\AirtimeTransaction;
use App\Models\DataTransaction;
use App\Models\EducationTransaction;
use App\Models\ElectricityTransaction;
use App\Models\FundTransaction;
use App\Models\InsuranceTransaction;
use App\Models\Notification;
use App\Models\TvTransaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class usersController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::guard('web')->user();

        // Retrieve all data for the user from the database
        $userData = User::where('id', $user->id)->first();
        $username = $userData->username;
                                                        // Check the action query parameter
        $action        = $request->query('action', ''); // Default to empty string if not set
        $hideModal     = ($action === 'hideModal');
        $showModal     = ($action === 'showModal');
        $notifications = Notification::where('username', $user->username)->get();

        $totalDebitedAmount = AirtimeTransaction::where('user_id', $user->user_id)->sum('amount') +
        DataTransaction::where('user_id', $user->id)->sum('amount') +
        TvTransaction::where('user_id', $user->id)->sum('amount') +
        InsuranceTransaction::where('user_id', $user->id)->sum('amount') +
        ElectricityTransaction::where('user_id', $user->id)->sum('amount') +
        EducationTransaction::where('user_id', $user->id)->sum('amount');

        $totalCreditedAmount       = WalletTransaction::with('transaction')->where('wallet_owner_type', User::class)->where('wallet_owner_id', $user->id)->where('type', 'credit')->sum('amount');
        $totalCreditedTransactions = WalletTransaction::where('wallet_owner_id', $user->id)->where('wallet_owner_type', User::class)->where('type', 'credit')->count();

        $totalAirtimeTransactions     = AirtimeTransaction::where('user_id', $user->id)->count();
        $totalDataTransaction         = DataTransaction::where('user_id', $user->id)->count();
        $totalTvTransaction           = TvTransaction::where('user_id', $user->id)->count();
        $totalEducationTransactions   = EducationTransaction::where('user_id', $user->id)->count();
        $totalElectricityTransactions = ElectricityTransaction::where('user_id', $user->id)->count();
        $totalInsuranceTransactions   = InsuranceTransaction::where('user_id', $user->id)->count();

        // Calculate the total number of transactions
        $totalTransactions = $totalAirtimeTransactions + $totalDataTransaction +
            $totalTvTransaction + $totalEducationTransactions +
            $totalElectricityTransactions + $totalInsuranceTransactions;

        // Fetch recent transactions from each model
        $airtimeTransactions = AirtimeTransaction::where('user_id', $user->id)->with('transaction')
            ->orderBy('created_at', 'desc')
            ->get();

        $DataTransaction = DataTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $educationTransactions = EducationTransaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $electricityTransactions = ElectricityTransaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $fundTransactions = WalletTransaction::where('wallet_owner_id', $user->id)
            ->where('wallet_owner_type', User::class)
            ->where('type', 'credit')
            ->orderBy('created_at', 'desc')
            ->get();

        $insuranceTransactions = InsuranceTransaction::where('user_id', $user->id)->with('transaction')
            ->orderBy('transaction_date', 'desc')
            ->get();

        $tvTransactions = TvTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Combine all transactions and sort by date
        $transactions = $airtimeTransactions
            ->merge($DataTransaction)
            ->merge($educationTransactions)
            ->merge($electricityTransactions)
            ->merge($fundTransactions)
            ->merge($insuranceTransactions)
            ->merge($tvTransactions)
            ->sortByDesc('created_at') // Sort all transactions by date
            ->take(5);                 // Get the 5 most recent transactions

        $configuration = Helper::merchant()->preferences;

        $walletBalance = Wallet::where('owner_id', $user->id)
            ->where('owner_type', User::class)
            ->value('balance');
        // Pass the data and the flag to the view
        return view('users-layout.dashboard.dashboard', [
            'userData'      => $userData,
            'hideModal'     => $hideModal,
            'notifications' => $notifications,
            'showModal'     => $showModal,
        ], compact('totalDebitedAmount', 'totalTransactions', 'totalCreditedAmount', 'totalCreditedTransactions', 'transactions', 'configuration', 'walletBalance'));
    }

    public function calculateTransactions(Request $request)
    {
        try {
            // Get the raw input dates
            $startDateInput = $request->input('startDate');
            $endDateInput   = $request->input('endDate');

            // Parse dates from 'YYYY-MM-DD' format
            $startDate = Carbon::createFromFormat('Y-m-d', $startDateInput)->startOfDay();
            $endDate   = Carbon::createFromFormat('Y-m-d', $endDateInput)->endOfDay();

            // Rest of your logic
            $airtimeTransactions     = AirtimeTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $DataTransaction         = DataTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $educationTransactions   = EducationTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $electricityTransactions = ElectricityTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $insuranceTransactions   = InsuranceTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $fundTransactions        = FundTransaction::whereBetween('created_at', [$startDate, $endDate])->get();

            $totalDebitedAmount = $airtimeTransactions->sum('amount') +
            $DataTransaction->sum('amount') +
            $educationTransactions->sum('amount') +
            $electricityTransactions->sum('amount') +
            $insuranceTransactions->sum('amount');

            $totalCreditedAmount = $fundTransactions->sum('amount');

            $summary = [
                'airtime'             => [
                    'mtn_data_sold'        => $DataTransaction->where('network', 'mtn')->sum('amount'),
                    'mtn_airtime_sold'     => $airtimeTransactions->where('network', 'mtn')->sum('amount'),
                    'glo_data_sold'        => $DataTransaction->where('network', 'glo')->sum('amount'),
                    'glo_airtime_sold'     => $airtimeTransactions->where('network', 'glo')->sum('amount'),
                    '9mobile_data_sold'    => $DataTransaction->where('network', '9mobile')->sum('amount'),
                    '9mobile_airtime_sold' => $airtimeTransactions->where('network', '9mobile')->sum('amount'),
                    'airtel_data_sold'     => $DataTransaction->where('network', 'airtel')->sum('amount'),
                    'airtel_airtime_sold'  => $airtimeTransactions->where('network', 'airtel')->sum('amount'),
                ],
                'totalDebitedAmount'  => $totalDebitedAmount,
                'totalCreditedAmount' => $totalCreditedAmount,
            ];

            return response()->json([
                'status' => 'success',
                'data'   => $summary,
            ]);
        } catch (\Exception $e) {
            // Return detailed error message
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ], 400);
        }
    }

    public function generateUserEmailsCSV()
    {
        // Retrieve all user emails
        $users = User::select('email')->get();

        // Define CSV headers
        $csvHeader = ['Email'];

                                                    // Create a CSV file content
        $csvData = implode(",", $csvHeader) . "\n"; // Add header row
        foreach ($users as $user) {
            $csvData .= $user->email . "\n"; // Add each user email row
        }

        // Define the filename for download
        $filename = 'user_emails_' . now()->format('Ymd_His') . '.csv';

        // Return the CSV file as a response with the correct headers for download
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}
