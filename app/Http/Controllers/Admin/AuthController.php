<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin-layout.auth.login');
    }

    /**
     * Handle the admin login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {

        $request->validate([
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember' => 'boolean',
        ]);
        // Validate and authenticate the admin
        $credentials = $request->only('email', 'password');

        if (! Auth::guard('admin')->attempt($credentials, $request->remember)) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);

        }

        return redirect()->intended(route('admin.dashboard'))->with('success', 'Login successful!');
    }

    /**
     * Handle the admin logout request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
