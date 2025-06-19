<?php
namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Models\AirtimeTransaction;
use App\Models\dataTransactions;
use App\Models\EducationTransaction;
use App\Models\EletricityTransaction;
use App\Models\FundTransaction;
use App\Models\InsuranceTransaction;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\TvTransactions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class usersController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            $username = $userData->username;
                                                            // Check the action query parameter
            $action        = $request->query('action', ''); // Default to empty string if not set
            $hideModal     = ($action === 'hideModal');
            $showModal     = ($action === 'showModal');
            $notifications = Notification::where('username', $user->username)->get();

            $totalDebitedAmount = AirtimeTransaction::where('username', $user->username)->sum('amount') +
            DataTransactions::where('username', $user->username)->sum('amount') +
            TvTransactions::where('username', $user->username)->sum('amount') +
            InsuranceTransaction::where('username', $user->username)->sum('amount') +
            EletricityTransaction::where('username', $user->username)->sum('amount') +
            EducationTransaction::where('username', $user->username)->sum('amount');

            $totalCreditedAmount       = FundTransaction::where('username', $user->username)->sum('amount');
            $totalCreditedTransactions = FundTransaction::where('username', $user->username)->count();

            $totalAirtimeTransactions     = AirtimeTransaction::where('username', $user->username)->count();
            $totalDataTransactions        = DataTransactions::where('username', $user->username)->count();
            $totalTvTransactions          = TvTransactions::where('username', $user->username)->count();
            $totalEducationTransactions   = EducationTransaction::where('username', $user->username)->count();
            $totalElectricityTransactions = EletricityTransaction::where('username', $user->username)->count();
            $totalInsuranceTransactions   = InsuranceTransaction::where('username', $user->username)->count();

            // Calculate the total number of transactions
            $totalTransactions = $totalAirtimeTransactions + $totalDataTransactions +
                $totalTvTransactions + $totalEducationTransactions +
                $totalElectricityTransactions + $totalInsuranceTransactions;

            // Fetch recent transactions from each model
            $airtimeTransactions = AirtimeTransaction::selectRaw('"Airtime" as type, network as logo, amount, status, created_at')
                ->where('username', $username)
                ->orderBy('created_at', 'desc')
                ->get();

            $dataTransactions = DataTransactions::selectRaw('"Data" as type, network as logo, amount, status, created_at')
                ->where('username', $username)
                ->orderBy('created_at', 'desc')
                ->get();

            $educationTransactions = EducationTransaction::selectRaw('"Education" as type, product_name as logo, amount, status, transaction_date as created_at')
                ->where('username', $username)
                ->orderBy('transaction_date', 'desc')
                ->get();

            $electricityTransactions = EletricityTransaction::selectRaw('"Electricity" as type, product_name as logo, amount, status, transaction_date as created_at')
                ->where('username', $username)
                ->orderBy('transaction_date', 'desc')
                ->get();

            $fundTransactions = FundTransaction::selectRaw('"Fund" as type, username as logo, amount, status, created_at')
                ->where('username', $username)
                ->orderBy('created_at', 'desc')
                ->get();

            $insuranceTransactions = InsuranceTransaction::selectRaw('"Insurance" as type, product_name as logo, amount, status, transaction_date as created_at')
                ->where('username', $username)
                ->orderBy('transaction_date', 'desc')
                ->get();

            $tvTransactions = TvTransactions::selectRaw('"TV" as type, network as logo, amount, status, created_at')
                ->where('username', $username)
                ->orderBy('created_at', 'desc')
                ->get();

            // Combine all transactions and sort by date
            $transactions = $airtimeTransactions
                ->merge($dataTransactions)
                ->merge($educationTransactions)
                ->merge($electricityTransactions)
                ->merge($fundTransactions)
                ->merge($insuranceTransactions)
                ->merge($tvTransactions)
                ->sortByDesc('created_at') // Sort all transactions by date
                ->take(5);                 // Get the 5 most recent transactions

            $configuration = Setting::first();
            // Pass the data and the flag to the view
            return view('users-layout.dashboard.dashboard', [
                'userData'      => $userData,
                'hideModal'     => $hideModal,
                'notifications' => $notifications,
                'showModal'     => $showModal,
            ], compact('totalDebitedAmount', 'totalTransactions', 'totalCreditedAmount', 'totalCreditedTransactions', 'transactions', 'configuration'));
        }

        // Handle the case where the user is not authenticated
        return redirect()->route('login', [
            'slug' => Helper::merchant()->slug,
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
            $dataTransactions        = DataTransactions::whereBetween('created_at', [$startDate, $endDate])->get();
            $educationTransactions   = EducationTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $electricityTransactions = EletricityTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $insuranceTransactions   = InsuranceTransaction::whereBetween('created_at', [$startDate, $endDate])->get();
            $fundTransactions        = FundTransaction::whereBetween('created_at', [$startDate, $endDate])->get();

            $totalDebitedAmount = $airtimeTransactions->sum('amount') +
            $dataTransactions->sum('amount') +
            $educationTransactions->sum('amount') +
            $electricityTransactions->sum('amount') +
            $insuranceTransactions->sum('amount');

            $totalCreditedAmount = $fundTransactions->sum('amount');

            $summary = [
                'airtime'             => [
                    'mtn_data_sold'        => $dataTransactions->where('network', 'mtn')->sum('amount'),
                    'mtn_airtime_sold'     => $airtimeTransactions->where('network', 'mtn')->sum('amount'),
                    'glo_data_sold'        => $dataTransactions->where('network', 'glo')->sum('amount'),
                    'glo_airtime_sold'     => $airtimeTransactions->where('network', 'glo')->sum('amount'),
                    '9mobile_data_sold'    => $dataTransactions->where('network', '9mobile')->sum('amount'),
                    '9mobile_airtime_sold' => $airtimeTransactions->where('network', '9mobile')->sum('amount'),
                    'airtel_data_sold'     => $dataTransactions->where('network', 'airtel')->sum('amount'),
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
