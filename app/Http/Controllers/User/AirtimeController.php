<?php
namespace App\Http\Controllers\User;

use App\Models\User;
use App\Classes\Helper;
use App\Models\Product;
use App\Enums\ProductTypes;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\AirtimeService;
use App\Models\AirtimeTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AirtimeController extends Controller
{
    private $airtimeService;

    public function __construct(AirtimeService $airtimeService)
    {
        $this->airtimeService = $airtimeService;

    }

    public function indexAction()
    {
        $user = Auth::guard('web')->user();

        return view('users-layout.dashboard.airtime', [
            'userData'        => $user,
            'notifications'   => Notification::where('username', $user->username)->get(),
            'airtimeProducts' => Product::where('type', ProductTypes::AIRTIME->value)
                ->where('is_active', true)
                ->get(),
        ]);
    }

    public function purchaseAirtime(Request $request)
    {
        $airtimeProducts = Product::where('type', ProductTypes::AIRTIME->value)
            ->where('is_active', true)
            ->get();

        $validated = $request->validate([
            'network' => "required|in:{$airtimeProducts->pluck('slug')->implode(',')}",
            'amount'  => 'required|numeric|min:1',
            'tel'     => 'required|numeric',
        ]);

        $user = Auth::guard('web')->user();

        $slug = $validated['network'];

        $this->airtimeService->setSettings(Helper::merchant()->preferences);

        if ($user->wallet->balance < $validated['amount']) {
            return response()->json(['status' => 'failed', 'message' => 'Insufficient funds']);
        }

        $finalAmount = $this->airtimeService->calculateFinalAmount(
            $user,
            $validated['amount'],
            $slug
        );

        if (! $finalAmount) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid user type or network']);
        }

        $requestId = $this->airtimeService->generateRequestId();

        try {
            DB::beginTransaction();

            $product = Product::where('slug', $validated['network'])
                ->where('type', ProductTypes::AIRTIME->value)
                ->first();
            $result = $this->airtimeService->purchaseAirtime(
                $requestId,
                $product->service_name,
                $validated['amount'],
                $validated['tel'],
                $user->email
            );

            if (! isset($result['content']['transactions']['status']) || $result['content']['transactions']['status'] !== 'delivered') {
                throw new \Exception('Airtime purchase failed');
            }

            $verificationResult = $this->airtimeService->verifyTransaction($requestId);

            if ($verificationResult['code'] !== '000') {
                throw new \Exception('Transaction verification failed');
            }

            $currentBalance = $user->wallet->balance - $finalAmount;
            $user->wallet()->update(['balance' => $currentBalance]);

            $transaction = Transaction::initialize([
                'transactable_type' => User::class,
                'transactable_id'   => $user->id,
                'kind'              => 'debit',
                'amount'            => $validated['amount'],
                'type'              => ProductTypes::AIRTIME->value,
                'payload'           => [
                    'User Name'        => $user->name,
                    'User Email'       => $user->email,
                    'description'      => "{$product->service_name} Airtime Purchase",
                    "Transaction Type" => 'Airtime Purchase',
                ],
            ]);

            AirtimeTransaction::create([
                'user_id'        => $user->id,
                'transaction_id' => $transaction->id,
                'network'        => $product->service_name,
                'tel'            => $validated['tel'],
                'amount'         => $validated['amount'],
                'prev_bal'       => $user->wallet->balance,
                'current_bal'    => $currentBalance,
                'percent_profit' => $validated['amount'] - $finalAmount,
                'reference'      => $verificationResult['content']['transactions']['transactionId'],
                'identity'       => $verificationResult['content']['transactions']['unique_element'],
                'status'         => $verificationResult['content']['transactions']['status'],
            ]);

            DB::commit();
            return response()->json(['status' => 'delivered', 'message' => 'Airtime purchase successful', 'result' => $result]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
