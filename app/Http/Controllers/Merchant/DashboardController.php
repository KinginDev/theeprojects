<?php
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

}
