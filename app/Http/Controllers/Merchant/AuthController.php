<?php
namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $merchant           = new Merchant();
        $merchant->name     = $request->name;
        $merchant->email    = $request->email;
        $merchant->slug     = Str::slug($request->name);
        $merchant->phone    = $request->phone;
        $merchant->password = bcrypt($request->password);
        $merchant->domain   = str_replace(' ', '_', strtolower($merchant->name)) . '.' . env('APP_DOMAIN');
        $merchant->save();

        // Log the merchant in
        $credentials = $request->only('email', 'password');
        if (! \Auth::guard('merchant')->attempt($credentials)) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);
        }

        // Redirect to merchant dashboard
        return redirect()->intended(route('merchant.dashboard'))->with('success', 'Registration successful! Welcome to your dashboard.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember' => 'boolean',
        ]);

        if (\Auth::guard('merchant')->attempt($request->only('email', 'password'), $request->remember)) {
            // Authentication successful
            return redirect()->route('merchant.dashboard')->with('success', 'Login successful!');
        } else {
            // Authentication failed
            return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);
        }
    }

    public function logout(Request $request)
    {
        // Handle merchant logout
        Auth::guard('merchant')->logout();
        return redirect()->route('merchant.login');
    }
}
