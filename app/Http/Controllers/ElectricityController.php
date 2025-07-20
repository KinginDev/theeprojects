<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Classes\Helper;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\ElectricityService;
use Illuminate\Support\Facades\Auth;

use App\Models\ElectricityTransaction;
use Symfony\Component\HttpFoundation\Response;

class ElectricityController extends Controller
{
      public function __construct(ElectricityService $electricityService)
    {
        $this->electricityService = $electricityService;
        $merchantConfig = Helper::merchant();
        $preferences = $merchantConfig->preferences;
        $this->electricityService->setSettings($preferences);
    }
      public function indexElectricity()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData      = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();

            $products = Product::where('type', 'electricity')
                ->where('is_active', true)
                ->get();
            $transactions = ElectricityTransaction::where('user_id', $user->id)
                ->orderBy('created_at', 'desc');


            $recentTransactions = $transactions->take(5)->get();

            // Group transactions by month and calculate total amount for each month
            $currentYear = now()->format('Y');
            $lastSixMonths = collect();

            // Create array with last 6 months with zero values
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $lastSixMonths->put(
                    $month->format('Y-m'),
                    [
                        'date' => $month->format('M'),
                        'amount' => 0,
                        'year' => $month->format('Y')
                    ]
                );
            }

            // Fill in actual transaction data
            $transactionData = $transactions->get()->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m');
            })->map(function ($transactions, $yearMonth) {
                return [
                    'date' => date('M', strtotime($yearMonth)),
                    'amount' => $transactions->sum('amount'),
                    'year' => date('Y', strtotime($yearMonth))
                ];
            });

            // Merge the prepared months with actual data
            foreach ($transactionData as $key => $value) {
                if ($lastSixMonths->has($key)) {
                    $lastSixMonths[$key] = $value;
                }
            }

            // Convert to array for chart
            $trxChartData = $lastSixMonths->values()->toArray();

            return view('users-layout.dashboard.electricity', [
                'userData'      => $userData,
                'notifications' => $notifications,
                'products'     => $products,
                'recentTransactions' => $recentTransactions,
                'trxChartData' => $trxChartData,
                'chartLabels' => collect($trxChartData)->pluck('date')->toJson(),
                'chartValues' => collect($trxChartData)->pluck('amount')->toJson()
            ]);
        }
    }
     /**
     * Purchase electricity token
     *
     * @param Request $request
     * @return Response
     */
    public function purchaseElectricity(Request $request)
    {
        try {
            // Get active electricity products
            $products = Product::where('type', 'electricity')
                ->where('is_active', true)
                ->get();

            // Validate request
            $validatedData = $this->validateElectricityRequest($request, $products->toArray());


            // Get authenticated user
            $user = User::where('id', Auth::id())->first();

            // Check if phone number is available
            $phone = $user->phone ?? $validatedData['phone'] ?? null;
            if (!$phone) {
                throw new \Exception('Phone number is required for electricity purchase.');
            }

            // Check user's wallet balance
            $userBalance = $user->wallet->balance ?? 0;
            if ($userBalance < $validatedData['amount']) {
                throw new \Exception('Insufficient wallet balance, please fund your wallet.');
            }

            // Get product and calculate profit percentage
            $product = Product::where('service_name', $validatedData['distribution_company'])
                ->where('type', 'electricity')
                ->with('percentage')
                ->first();

            $percentageValue = $product->percentage ? $product->percentage->percentage : 0;
            $finalAmount = $validatedData['amount'] * (1 - ($percentageValue / 100));
            $percentProfit = $validatedData['amount'] - $finalAmount;


            try {
                // Begin database transaction
                 DB::beginTransaction();
                // Prepare data for token request
                $tokenRequestData = [
                    'meter_number' => $validatedData['meter_number'],
                    'service_name' => $validatedData['distribution_company'],
                    'meter_type' => $validatedData['meter_type'],
                    'email' => $user->email,
                    'tel' => $phone,
                    'amount' => $finalAmount
                ];

                // Process token request
                $result = $this->processElectricityToken($tokenRequestData);


                // Create transactions
                $transactionResult = $this->createElectricityTransactions(
                    $user,
                    $validatedData,
                    $result,
                    $userBalance,
                    $percentProfit
                );

                // Commit transaction
                DB::commit();

                // Return success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Electricity purchase successful',
                    'data' => [
                        'token' => $transactionResult['purchaseCode'],
                        'amount' => $validatedData['amount'],
                        'reference' => $transactionResult['transaction']->reference,
                        'meter_number' => $validatedData['meter_number'],
                        'meter_type' => $validatedData['meter_type']
                    ]
                ]);

            } catch (\Exception $e) {
                DB::rollBack();

                // Return detailed error for better debugging
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaction processing failed: ' . $e->getMessage(),
                    'error' => true,
                ], Response::HTTP_BAD_REQUEST);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                 'error' => true,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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

        // Set up API request data
        $data = [
            "meter_number" => $billerCode,
            "service_name"   => $distributionCompany,
            "type"        => $meterType,
        ];

        try{
            $result = $this->electricityService->verifyMeterNumber($data);
            $errorCodes = $this->electricityService->errorCodes;
            $this->electricityService->processVTPassVerifyResultForErrors($result, $errorCodes);



            return response()->json([
                'status' => 'success',
                'message' => 'Meter number verified successfully',
                'data' => $result['content'],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json([
            'status' => 'failed',
            'message' => $e->getMessage(),
            'error' => true,
        ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Validate electricity purchase request
     *
     * @param Request $request
     * @param array $products
     * @return array|Response
     */
    private function validateElectricityRequest(Request $request, array $products)
    {
        try {
            return $request->validate([
                'distribution_company' => 'required|in:' . collect($products)->pluck('service_name')->implode(','),
                'meter_type' => 'required|in:prepaid,postpaid',
                'meter_number' => 'required',
                'amount' => 'required|numeric|min:1',
                'phone' => 'numeric',
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Validation failed: ' . $e->getMessage());
        }
    }

    /**
     * Process electricity token purchase
     *
     * @param array $data
     * @return array|Response
     */
    private function processElectricityToken(array $data)
    {
        $result = $this->electricityService->requestToken($data);
        $errorCodes = $this->electricityService->errorCodes;

        $this->electricityService->processVTPassPurchaseResultForErrors($result, $errorCodes);

        return $result;
    }

    /**
     * Create transactions for electricity purchase
     *
     * @param User $user
     * @param array $validatedData
     * @param array $result
     * @param float $userBalance
     * @param float $percentProfit
     * @return array|Response
     */
    private function createElectricityTransactions(User $user, array $validatedData, array $result, float $userBalance, float $percentProfit)
    {
        $responseContent = $result['content']['transactions'];
        $purchaseCode = $result['purchased_code'] ?? $result['token'];
        $requestId = $result['requestId'] ?? $result['request_id'] ?? null;
        $phone = $user->phone ?? $validatedData['phone'];
        $email = $user->email;

        // Create main transaction record
        $transaction = Transaction::initialize([
            'transactable_type' => User::class,
            'transactable_id' => $user->id,
            'amount' => $validatedData['amount'],
            'type' => 'electricity',
            'kind' => 'debit',
            'status' => 'success',
            'payload' => [
                'meter_number' => $validatedData['meter_number'],
                'distribution_company' => $validatedData['distribution_company'],
                'type' => $validatedData['meter_type'],
                'email' => $email,
                'tel' => $phone,
            ],
            'reference' => $requestId
        ]);

        // Calculate new balance
        $currentBal = $userBalance - $validatedData['amount'];

        // Update user's wallet balance
        $user->wallet->update(['balance' => $currentBal]);

        // Create wallet transaction
        WalletTransaction::create([
            'wallet_owner_id' => $user->id,
            'wallet_owner_type' => User::class,
            'wallet_id' => $user->wallet->id,
            'transaction_id' => $transaction->id,
            'amount' => $validatedData['amount'],
            'type' => 'debit',
            'description' => 'Electricity purchase for meter ' . $validatedData['meter_number'],
            'prev_balance' => $userBalance,
            'current_balance' => $currentBal
        ]);

        // Create electricity transaction record
        ElectricityTransaction::create([
            'user_id' => $user->id,
            'transaction_id' => $transaction->id,
            'username' => $user->username,
            'product_name' => $validatedData['distribution_company'],
            'type' => $validatedData['meter_type'],
            'tel' => $phone,
            'amount' => $validatedData['amount'],
            'reference' => $transaction->reference,
            'purchased_code' => $purchaseCode,
            'response_description' => $responseContent['response_description'] ?? 'Transaction successful',
            'transaction_date' => now(),
            'identity' => $validatedData['meter_number'],
            'prev_bal' => $userBalance,
            'current_bal' => $currentBal,
            'percent_profit' => $percentProfit,
            'status' => $responseContent['status']
        ]);

        // Update main transaction status
        $transaction->update([
            'status' => 'success',
            'provider_reference' => $purchaseCode
        ]);

        return [
            'transaction' => $transaction,
            'purchaseCode' => $purchaseCode,
        ];
    }




}
