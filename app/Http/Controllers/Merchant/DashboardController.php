<?php
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\FundTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // This method will return the dashboard view for the merchant
        return view('merchant-layout.dashboard.index');
    }

    public function getMerchantUsers($merchantId)
    {
        $users = User::where('merchant_id', $merchantId)->get();
        return view('merchant-layout.dashboard.users.all-users')->with(compact('users'));
    }

    public function createUser(Request $request, $merchantId)
    {
        // Logic to create a new user for the merchant
        // This could involve showing a form or processing a request
        return view('merchant-layout.dashboard.users.create', ['merchantId' => $merchantId]);
    }
    /**
     * Show the form for crediting a user's account.
     *
     * @return \Illuminate\View\View
     */
    public function creditUserAccount()
    {
        $merchant    = Auth::guard('merchant')->user();
        $users       = User::where('merchant_id', $merchant->id)->get();
        $fundAccount = FundTransaction::where('identity', 'like', '%Manual Funding%')
            ->orderBy('created_at', 'desc')
            ->get();

        // Logic to credit a user's account
        return view('merchant-layout.dashboard.users.credit-account')->with(compact('users', 'fundAccount'));
    }

    /**
     * Show the form for adding funds to a user's account.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function addFund($userId)
    {
        $user = User::find($userId);
        return view('merchant-layout.addFund', compact('user'));
    }

    /**
     * Show the form for approving funds for a user.
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function approveFund($userId)
    {
        $funding = FundTransaction::find($userId);
        return view('merchant-layout.approveFund', compact('funding'));
    }

}
