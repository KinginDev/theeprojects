<?php
namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Models\DataTransaction;
use App\Models\Notification;
use App\Models\Percentage;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class dataController extends Controller
{
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
        $this->dataService->setSettings(Helper::merchant()->preferences);
    }

    public function indexAction()
    {
        try {
            $data = $this->dataService->getLucyRoseNetworkData();
            $user = Auth::user();

            if (!$user) {
                return redirect()->route('login');
            }

            // Define the service types for data plans
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

            // Determine the user's account type for percentage calculation
            $userAccountType = $this->getUserAccountType($user);

            // Get percentage data for the user's account type
            $percentages = [];
            if ($userAccountType) {
                $percentages = Percentage::whereIn('service', $services)
                    ->select('service', $userAccountType . ' as percent')
                    ->get();
            }

            $transactions = DataTransaction::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('users-layout.dashboard.data', [
                'networks' => $data,
                'data_types' => ['SME', 'SME 2', 'GIFTING', 'CORPORATE GIFTING'],
                'userData' => $user,
                'transactions' => $transactions,
                'notifications' => Notification::where('username', $user->username)->get(),
                'percentages' => $percentages,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Process data purchase for MTN and Airtel gifting
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataPurchaseMtnAirtelGifting(Request $request)
    {
        // Validate the request
       $validated = $request->validate([
            'network' => 'required|in:1,4', // Only MTN (1) and Airtel (4) supported
            'type' => 'required|string',
            'tel' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $user = Auth::guard('web')->user();
        try {
            DB::beginTransaction();
            // Process using service
        $result = $this->dataService->processDataGiftingPurchase(
            $request->only(['network', 'type', 'tel', 'amount']),
           $user
        );

        if (!isset($result['content']['transactions']['status'])
                || $result['content']['transactions']['status'] !== 'delivered') {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Data purchase failed',
                    'result' => $result
                ]);
        }

         // Create transaction record
            $transaction = Transaction::initialize([
                'transactable_type' => User::class,
                'transactable_id' => $user->id,
                'kind' => 'debit',
                'amount' => $validated['amount'],
                'type' => 'data',
                'payload' => [
                    'User Name' => $user->name,
                    'User Email' => $user->email,
                    'description' => "Data Purchase",
                    'Network' => $this->dataService->getNetworkName($validated['network']),
                    'Phone Number' => $validated['tel'],
                    'Plan' => $validated['type'],
                ],
            ]);

            // Create data transaction record
            $currentBalance = $user->wallet->balance - $validated['amount'];

            $user->wallet()
                ->update(['balance' => $currentBalance]);

            $finalAmount = $this->dataService->calculateFinalAmount(
                $user,
                $validated['amount'],
                $this->dataService->getServiceName($validated['network'], $validated['type'])
            );


            DataTransaction::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction->id,
                'api_response' => $result['content']['transactions']['product_name'] ?? 'No product name',
                'network' => $this->dataService->getNetworkName($validated['network']),
                'tel' => $validated['tel'],
                'plan' => $validated['type'],
                'amount' => $finalAmount,
                'reference' => $result['content']['transactions']['transactionId'],
                'identity' => 'Data Purchase',
                'prev_bal' => $user->wallet->balance,
                'current_bal' => $currentBalance,
                'percent_profit' => $validated['amount'] - $finalAmount,
                'status' => $result['content']['transactions']['status']
            ]);


        return response()->json([
            'status' => $result['content']['transactions']['status'],
            'message' => $result['message'],
            'result' => $result['result'] ?? null
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'failed',
            'message' => $e->getMessage()
        ]);
        }
    }

    /**
     * Get data variations for MTN and Airtel networks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataMtnAirtelGifting(Request $request)
    {

        // Validate request
        $validated = $request->validate([
            'network' => 'required|in:1,4'
        ], [
            'network.required' => 'Network is required',
            'network.in' => 'Invalid network selected. Only MTN and Airtel are supported for Gifting plans.'
        ]);

        $user = Auth::guard('web')->user();

        // Get data variations from service
        $result = $this->dataService->getDataVariations(
            (int)$validated['network'],
            $user
        );

        return response()->json($result);
    }

    public function purchaseData(Request $request)
    {
        $validated = $request->validate([
            'network' => 'required|in:1,2,4,6',
            'networkType' => 'required',
            'amount' => 'required|numeric',
            'tel' => 'required|numeric',
            'type' => 'required',
        ], [
            'network.required' => 'Network is required',
            'network.in' => 'Invalid network selected. Only MTN, GLO, Airtel, and 9mobile are supported.',
            'networkType.required' => 'Network type is required',
            'amount.required' => 'Amount is required',
            'tel.required' => 'Phone number is required',
            'type.required' => 'Data plan type is required',
            'tel.numeric' => 'Phone number must be numeric',
            'amount.numeric' => 'Amount must be a numeric value',
            'amount.min' => 'Amount must be at least 1',
            'amount.max' => 'Amount exceeds the maximum limit allowed',
            'networkType.in' => 'Invalid network type selected. Only SME, SME 2, GIFTING, and CORPORATE GIFTING are supported.'
        ]);

        $user = Auth::guard('web')->user();

        // Get service name for the network and type
        $serviceName = $this->dataService->getServiceName($validated['network'], $validated['networkType']);
        if (!$serviceName) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid network or network type selected'
            ]);
        }

        // Calculate the final amount with profit deducted
        $finalAmount = $this->dataService->calculateFinalAmount($user, $validated['amount'], $serviceName);
        if (!$finalAmount) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid user type or network'
            ]);
        }

        // Check if user has sufficient balance
        if ($user->wallet->balance < $finalAmount) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Insufficient funds'
            ]);
        }

        try {
            DB::beginTransaction();

            $requestId = $this->dataService->generateRequestId();
            $result = $this->dataService->purchaseData(
                $requestId,
                $validated['network'],
                $validated['networkType'],
                $validated['tel'],
                $validated['type'],
                $validated['amount']
            );

            // Verify the result
            if (!isset($result['content']['transactions']['status']) || $result['content']['transactions']['status'] !== 'delivered') {
                throw new \Exception('Data purchase failed');
            }

            $userBalance = $user->wallet->balance;

            // Update user's balance
            $currentBalance = $userBalance - $finalAmount;
            $user->wallet()->update(['balance' => $currentBalance]);

            // Create transaction record
            $transaction = Transaction::initialize([
                'transactable_type' => User::class,
                'transactable_id' => $user->id,
                'kind' => 'debit',
                'amount' => $validated['amount'],
                'type' => 'data',
                'payload' => [
                    'User Name' => $user->name,
                    'User Email' => $user->email,
                    'description' => "Data Purchase",
                    'Network' => $this->dataService->getNetworkName($validated['network']),
                    'Phone Number' => $validated['tel'],
                    'Plan' => $validated['type'],
                ],
            ]);

            $currentBal = $userBalance - $validated['amount'];

            //Create wallet transaction
                WalletTransaction::create([
                    'wallet_owner_id' => $user->id,
                    'wallet_owner_type' => User::class,
                    'wallet_id' => $user->wallet->id,
                    'transaction_id' => $transaction->id,
                    'amount' => $validated['amount'],
                    'type' => 'debit',
                    'description' => 'Electricity purchase for meter ' . $validated['meter_number'],
                    'prev_balance' => $userBalance,
                    'current_balance' => $currentBal
                ]);


            // Create data transaction record
            DataTransaction::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction->id,
                'api_response' => $result['content']['transactions']['product_name'] ?? 'No product name',
                'network' => $this->dataService->getNetworkName($validated['network']),
                'tel' => $validated['tel'],
                'plan' => $validated['type'],
                'amount' => $finalAmount,
                'reference' => $result['content']['transactions']['transactionId'],
                'identity' => 'Data Purchase',
                'prev_bal' => $user->wallet->balance,
                'current_bal' => $currentBalance,
                'percent_profit' => $validated['amount'] - $finalAmount,
                'status' => 'successful'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'delivered',
                'message' => 'Data purchase successful',
                'result' => $result
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getNetworkPlans(Request $request)
    {

        try {
            $data = $this->dataService->getLucyRoseNetworkData();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getUserAccountType(User $user): ?string
    {
        if ($user->smart_earners) {
            return 'smart_earners_percent';
        } elseif ($user->topuser_earners) {
            return 'topuser_earners_percent';
        } elseif ($user->api_earners) {
            return 'api_earners_percent';
        }
        return null;
    }
}
