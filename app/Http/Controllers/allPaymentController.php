<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FundTransaction;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class allPaymentController extends Controller
{
    public function initializeMonnify(Request $request)
    {
        $configuration = Setting::first();
        $user = Auth::user(); // Retrieve the authenticated user
        $userBalance = $user->account_balance;

        $authorizedAmount = $request->input('authorizedAmount'); // Amount processed by Monnify
        $originalAmount = $request->input('originalAmount'); // Amount user intended to fund
        $status = $request->input('status');
        $transactionReference = $request->input('transactionReference');
        $identity = 'monnify';

        if ($status === "SUCCESS" && !empty($status)) {
            // Add the original amount to the user's balance
            User::where('user_id', $user->user_id)->update(['account_balance' => $userBalance + $originalAmount]);

            // Record the transaction in the fund_transactions table
            FundTransaction::create([
                'user_id' => $user->user_id,
                'username' => $user->username,
                'tel' => $user->tel,
                'amount' => $originalAmount, // Use the original amount
                'transaction_id' => $transactionReference,
                'identity' => $identity,
                'status' => $status,
                'prev_bal' => $user->account_balance,
                'current_bal' => $userBalance + $originalAmount,
            ]);

            // Check if this is the first funding for the user
            $isFirstFunding = FundTransaction::where('user_id', $user->user_id)->count() === 1;

            // Handle referral bonus logic for the first funding
            if ($isFirstFunding && !empty($user->refferal_user)) {
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
                'status' => 'success',
                'message' => 'Account Funded successfully',
                'notifications' => $notifications,
            ]);
        } else {
            return response()->json([
                'status' => 'cancelled',
                'message' => 'Account Funded cancelled',
            ]);
        }
    }


    public function manualFunding(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'bankTo' => 'required|string',
            'narrate' => 'required|string',
            'amountTo' => 'required|numeric|min:1',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a unique transaction ID
        $transactionId = 'TRX' . strtoupper(uniqid());

        try {
            // Insert the new manual fund transaction
            FundTransaction::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'tel' => $user->tel,
                'amount' => $validatedData['amountTo'],
                'transaction_id' => $transactionId,
                'identity' => 'Manual Funding|' . $validatedData['bankTo'] . '|' . $validatedData['narrate'], // You can adjust this identity as needed
                'status' => 'pending', // Initially pending until confirmed
            ]);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Manual funding request submitted successfully. Please wait for approval.',
            ]);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
