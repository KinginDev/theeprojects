<?php
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('merchant-layout.auth.login');
    }

    public function showRegisterForm()
    {
        return view('merchant-layout.auth.register');
    }

    public function register(Request $request)
    {
        // Validate and create a new merchant
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:merchants',
            'password' => 'required|string|min:8|confirmed',
            'terms'    => 'accepted',
        ]);

        $merchant = \App\Models\Merchant::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'slug'     => Str::slug($request->name),
            'phone'    => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        // Log the merchant in
        $credentials = $request->only('email', 'password');
        if (! \Auth::guard('merchant')->attempt($credentials)) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);
        }

        // Redirect to merchant dashboard
        return redirect()->route('merchant.dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
    }

    public function login(Request $request)
    {
        // Validate and authenticate the merchant
        // Redirect to dashboard on success
    }

    public function logout(Request $request)
    {
        // Handle merchant logout
        return redirect()->route('merchant.login');
    }
}
