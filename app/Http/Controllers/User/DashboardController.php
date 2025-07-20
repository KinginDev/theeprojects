<?php
namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Classes\Helper;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\TvTransaction;
use App\Models\DataTransaction;
use App\Models\FundTransaction;
use App\Models\WalletTransaction;
use App\Models\AirtimeTransaction;
use App\Http\Controllers\Controller;
use App\Models\EducationTransaction;
use App\Models\InsuranceTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\ElectricityTransaction;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with various statistics and recent transactions.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $user = Auth::guard('web')->user();


        $userId = $user->id;
        $action = $request->query('action', '');

        // Eager load notifications with a single query
        $notifications = Notification::where('username', $user->username)->get();

        // Use query builder to get transaction totals in a single query per transaction type
        // This avoids multiple database round-trips
        $transactionCounts = [
            'airtime' => AirtimeTransaction::where('user_id', $userId)->count(),
            'data' => DataTransaction::where('user_id', $userId)->count(),
            'tv' => TvTransaction::where('user_id', $userId)->count(),
            'education' => EducationTransaction::where('user_id', $userId)->count(),
            'electricity' => ElectricityTransaction::where('user_id', $userId)->count(),
            'insurance' => InsuranceTransaction::where('user_id', $userId)->count(),
        ];

        // Calculate totals
        $totalTransactions = array_sum($transactionCounts);

        // Get total debited amount with a single query per transaction type
        $totalDebitedAmount = AirtimeTransaction::where('user_id', $userId)->sum('amount') +
            DataTransaction::where('user_id', $userId)->sum('amount') +
            TvTransaction::where('user_id', $userId)->sum('amount') +
            InsuranceTransaction::where('user_id', $userId)->sum('amount') +
            ElectricityTransaction::where('user_id', $userId)->sum('amount') +
            EducationTransaction::where('user_id', $userId)->sum('amount');

        // Credit transactions with proper type hinting
        $walletTransactions = WalletTransaction::where('wallet_owner_id', $userId)
            ->where('wallet_owner_type', User::class);

        $totalCreditedAmount = $walletTransactions->where('type', 'credit')->sum('amount');
        $totalCreditedTransactions = $walletTransactions->where('type', 'credit')->count();

        // Use UNION to efficiently fetch recent transactions from multiple tables
        $recentLimit = 10;

        // Fetch recent transactions with proper eager loading
        // Using collection for consistent sorting across different model types
        $transactions = collect()
            ->merge(AirtimeTransaction::with('transaction')->where('user_id', $userId)->latest()->limit($recentLimit)->get())
            ->merge(DataTransaction::where('user_id', $userId)->latest()->limit($recentLimit)->get())
            ->merge(EducationTransaction::where('user_id', $userId)->latest('transaction_date')->limit($recentLimit)->get())
            ->merge(ElectricityTransaction::where('user_id', $userId)->latest('transaction_date')->limit($recentLimit)->get())
            ->merge(WalletTransaction::where('wallet_owner_id', $userId)
                ->where('wallet_owner_type', User::class)
                ->where('type', 'credit')
                ->latest()
                ->limit($recentLimit)
                ->get())
            ->merge(InsuranceTransaction::with('transaction')->where('user_id', $userId)->latest('transaction_date')->limit($recentLimit)->get())
            ->merge(TvTransaction::where('user_id', $userId)->latest()->limit($recentLimit)->get())
            ->sortByDesc(function($transaction) {
                // Handle different date field names consistently
                return $transaction->created_at ?? $transaction->transaction_date ?? Carbon::now();
            })
            ->take(5);

        $configuration = Helper::merchant()->preferences;

        // Get wallet balance with a single query and default to 0 if null
        $walletBalance = (float)Wallet::where('owner_id', $userId)
            ->where('owner_type', User::class)
            ->value('balance') ?? 0;

        // Return view with data
        return view('users-layout.dashboard.dashboard', [
            'userData' => $user,
            'hideModal' => $action === 'hideModal',
            'showModal' => $action === 'showModal',
            'notifications' => $notifications,
            'totalDebitedAmount' => $totalDebitedAmount,
            'totalTransactions' => $totalTransactions,
            'totalCreditedAmount' => $totalCreditedAmount,
            'totalCreditedTransactions' => $totalCreditedTransactions,
            'transactions' => $transactions,
            'configuration' => $configuration,
            'walletBalance' => $walletBalance,
        ]);
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
