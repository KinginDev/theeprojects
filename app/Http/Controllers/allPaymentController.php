<?php
namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Models\FundTransaction;
use App\Models\Merchant;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Monnify\MonnifyLaravel\Facades\Monnify;

class AllPaymentController extends Controller
{
    public function initializeMonnify(Request $request)
    {
        $configuration = Setting::first();
        $user          = Auth::user(); // Retrieve the authenticated user
        $userBalance   = $user->account_balance;

        $authorizedAmount     = $request->input('authorizedAmount'); // Amount processed by Monnify
        $originalAmount       = $request->input('originalAmount');   // Amount user intended to fund
        $status               = $request->input('status');
        $transactionReference = $request->input('transactionReference');
        $identity             = 'monnify';

        if ($status === "SUCCESS" && ! empty($status)) {
            // Add the original amount to the user's balance
            User::where('user_id', $user->user_id)->update(['account_balance' => $userBalance + $originalAmount]);

            // Record the transaction in the fund_transactions table
            FundTransaction::create([
                'user_id'     => $user->user_id,
                'username'    => $user->username,
                'tel'         => $user->tel,
                'amount'      => $originalAmount, // Use the original amount
                'reference'   => $transactionReference,
                'identity'    => $identity,
                'status'      => $status,
                'prev_bal'    => $user->account_balance,
                'current_bal' => $userBalance + $originalAmount,
            ]);

            // Check if this is the first funding for the user
            $isFirstFunding = FundTransaction::where('user_id', $user->user_id)->count() === 1;

            // Handle referral bonus logic for the first funding
            if ($isFirstFunding && ! empty($user->refferal_user)) {
                $referrer = User::where('user_id', $user->refferal_user)->first();

                if ($referrer) {
                    $referralBonus = ($originalAmount * $configuration->bonus) / 100; // Calculate 5% of the original amount
                    $referrer->increment('account_balance', $referralBonus);
                    $referrer->increment('refferal_bonus', $referralBonus);
                }
            }

            // Retrieve user notifications
            $notifications = Notification::where('username', $user->username)->get();

            // Return a success response
            return response()->json([
                'status'        => 'success',
                'message'       => 'Account Funded successfully',
                'notifications' => $notifications,
            ]);
        } else {
            return response()->json([
                'status'  => 'cancelled',
                'message' => 'Account Funded cancelled',
            ]);
        }
    }

    public function makePayment(Request $request)
    {


        // Validate the request
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
            "totalAmount" => 'required|numeric|min:1',
            'type'   => 'nullable|string|in:wallet,manual_funding', //
        ]);

        // Retrieve the authenticated user
        $user          = Auth::guard('web')->user();
        $configuration = null;
        if (Auth::guard('web')->check()) {
            $user          = Auth::guard('web')->user();
            $configuration = Helper::merchant()->preferences;
        } else if (Auth::guard('merchant')->check()) {
            $user          = Auth::guard('merchant')->user();
            $configuration = $user->preferences;
        }

        config([
            'monnify.api_key' => $configuration->monnify_api_key,
            'monnify.secret_key' => $configuration->monnify_secret_key,
            'monnify.contract_code' => $configuration->monnify_contract_code
        ]);


        // Generate a unique transaction ID

        $transaction = DB::transaction(function () use ($user, $validatedData, $request) {

            if (Auth::guard('merchant')->check()) {
                $transaction = Transaction::initialize([
                    'transactable_type' => Merchant::class,
                    'transactable_id'   => $user->id,

                    'amount'            => $validatedData['totalAmount'],
                    'type'              => $request->type,
                    'payload'           => [
                        'Merchant Name'   => $user->name,
                        'Merchant domain' => $user->domain, // Initially pending until confirmed
                    ],
                ]);

                // Insert the new fund transaction
                $wt                    = new WalletTransaction();
                $wt->wallet_owner_id   = $user->id;
                $wt->wallet_owner_type = Merchant::class;
                $wt->wallet_id         = $user->wallet->id;
                $wt->transaction_id    = $transaction->id;
                $wt->amount            = $validatedData['totalAmount'];
                $wt->save();
            }

            if (Auth::guard('web')->check()) {
                $transaction = Transaction::initialize([
                    'transactable_type' => User::class,
                    'transactable_id'   => $user->id,

                    'amount'            => $validatedData['totalAmount'],
                    'type'              => $request->type,
                    'payload'           => [
                        'User Name'   => $user->name,
                        'User Email'  => $user->email, // Initially pending until confirmed
                        'redirectUrl' => route('users.dashboard', [
                            'slug' => Helper::merchant()->slug,
                        ]),
                    ],
                ]);

                // Insert the new fund transaction
                $wt                    = new WalletTransaction();
                $wt->wallet_owner_id   = $user->id;
                $wt->wallet_owner_type = User::class;
                $wt->wallet_id         = $user->wallet->id;
                $wt->transaction_id    = $transaction->id;
                $wt->amount            = $validatedData['totalAmount'];
                $wt->save();
            }

            DB::commit();

            return $transaction;
        });


        $data = [
            'amount'             => $transaction->amount,
            'customerName'       => $user->name,
            'customerEmail'      => $user->email,
            'paymentReference'   => $transaction->reference,
            'paymentDescription' => 'Payment for Service',
            'currencyCode'       => 'NGN',
            'contractCode'       => config('monnify.contract_code'),
            'redirectUrl'        => route('process.callback'),
            'paymentMethods'     => ['CARD', 'ACCOUNT_TRANSFER'],
        ];



        // dd(config('monnify'));


        $response = Monnify::transactions()->initialise($data);

        return redirect($response['body']['responseBody']['checkoutUrl']);

    }

    public function processCallback(Request $request)
    {
        $ref = $request->input('paymentReference');

        $transaction = Transaction::where('reference', $ref)->first();

        $redirectUrl = $transaction->payload['redirectUrl'] ?? route('merchant.dashboard');

        if (! $transaction) {
            return redirect($redirectUrl)->with('error', 'Invalid.');
        } else {
            if ($transaction->status === 'pending') {
                // Handle successful transaction
                $transaction->status = 'success';
                $transaction->save();
                if ($transaction->type) {
                    $this->{"handle" . ucfirst($transaction->type)}($transaction);
                }

            }
        }
        return redirect($redirectUrl)->with('success', 'Transaction successful.');

    }

    public function handleWallet($transaction)
    {

        if ($transaction->transactable_type === Merchant::class) {
            $merchant = Merchant::find($transaction->transactable_id);

            if ($merchant) {
                $wallet = Wallet::where('owner_id', $transaction->transactable_id)
                    ->where('owner_type', Merchant::class)
                    ->first();

                if ($wallet) {
                    $wallet->increment('balance', floatval($transaction->amount));
                }

                $walletTransaction = WalletTransaction::where('transaction_id', $transaction->id)
                    ->where('wallet_owner_id', $transaction->transactable_id)
                    ->where('wallet_owner_type', Merchant::class)
                    ->first();

                if ($walletTransaction && $walletTransaction->status !== 'success') {
                    $walletTransaction->status = 'success';
                    $walletTransaction->save();
                }

            }

        } elseif ($transaction->transactable_type === User::class) {

            $user = User::find($transaction->transactable_id);
            if ($user) {
                $wallet = Wallet::where('owner_id', $transaction->transactable_id)
                    ->where('owner_type', User::class)
                    ->first();
                if ($wallet) {
                    $wallet->increment('balance', floatval($transaction->amount));
                }
                $walletTransaction = WalletTransaction::where('transaction_id', $transaction->id)
                    ->where('wallet_owner_id', $transaction->transactable_id)
                    ->where('wallet_owner_type', User::class)
                    ->first();

                if ($walletTransaction && $walletTransaction->status !== 'success') {
                    $walletTransaction->status = 'success';
                    $walletTransaction->save();
                }
            }

        }
    }

    public function manualFunding(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'bankTo'   => 'required|string',
            'narrate'  => 'required|string',
            'amountTo' => 'required|numeric|min:1',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a unique transaction ID
        $transactionId = 'TRX' . strtoupper(uniqid());

        try {
            // Insert the new manual fund transaction
            FundTransaction::create([
                'user_id'   => $user->id,
                'username'  => $user->username,
                'tel'       => $user->tel,
                'amount'    => $validatedData['amountTo'],
                'reference' => $transactionId,
                'identity'  => 'Manual Funding|' . $validatedData['bankTo'] . '|' . $validatedData['narrate'], // You can adjust this identity as needed
                'status'    => 'pending',                                                                      // Initially pending until confirmed
            ]);

            // Return a success response
            return response()->json([
                'status'  => 'success',
                'message' => 'Manual funding request submitted successfully. Please wait for approval.',
            ]);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'status'  => 'failed',
                'message' => 'An error occurred while processing the request.',
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function processWebhook(Request $request)
    {
        dd($request->all());
    }
}
