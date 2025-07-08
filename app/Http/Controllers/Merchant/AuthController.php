<?php
namespace App\Http\Controllers\Merchant;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller {

    public function showLoginForm() {
        return view( 'merchant-layout.auth.login' );
    }

    public function showRegisterForm() {
        return view( 'merchant-layout.auth.register' );
    }

    public function register( Request $request ) {

        // Validate and create a new merchant
        $request->validate( [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:merchants',
            'password' => 'required|string|min:8|confirmed',
            'terms'    => 'accepted',
        ] );

        $data     = $request->only( 'name', 'email', 'phone', 'password' );
        $merchant = Merchant::createMerchant( $data );

        event( new Registered( $merchant ) );

        // Log the merchant in
        Auth::guard( 'merchant' )->login( $merchant );

        // Redirect to verification notice page
        return redirect()->route( 'merchant.verification.notice' )
            ->with( 'success', 'Please check your email to verify your account.' );
    }

    public function login( Request $request ) {
        $request->validate( [
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember' => 'boolean',
        ] );

        $credentials = $request->only( 'email', 'password' );
        $remember = $request->boolean( 'remember', false );

        if ( Auth::guard( 'merchant' )->attempt( $credentials, $remember ) ) {
            $request->session()->regenerate();

            $merchant = Merchant::find( Auth::guard( 'merchant' )->id() );

            $merchant->update( [
                'remember_token' => $request->input( 'remember' ) ? Hash::make( $merchant->email . $merchant->password ) : null,
            ] );

            // Authentication successful
            return redirect()->route( 'merchant.dashboard' )->with( 'success', 'Login successful!' );
        }

        return back()->withErrors( [
            'email' => 'The provided credentials do not match our records.',
        ] )->withInput( $request->only( 'email' ) );
    }


    public function showForgetPasswordPage()
    {
        return view('merchant-layout.auth.forget_password');
    }

    public function sendPasswordRequest(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Get the user's email from the request
        $email = $request->input('email');

        // Check if the user exists in the database
        $user = Merchant::where('email', $email)->first();

        if (! $user) {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['message' => 'Email address not found']);
        }

        // Create the password reset token
        $token = Password::createToken($user);

        // Prepare HTML content for the password reset email
        $htmlContent = "<html>
        <body>
            <h1>Password Reset Request</h1>
            <p>Hello {$user->name},</p>
            <p>We received a request to reset your password. Click the link below to reset your password:</p>
            <p><a href='" . route('merchant.password.reset', ['token' => $token, 'email' => $email]) . "'>Reset Password</a></p>
            <p>If you did not request a password reset, please ignore this email.</p>
        </body>
        </html>";

        // Send an email notification to the user
        try {
            Mail::send([], [], function ($mail) use ($email, $htmlContent) {
                $mail->to($email)
                    ->subject('Password Reset Request')
                    ->html($htmlContent);
            });

            // Log that the email was sent successfully
            Log::info('Password reset email sent successfully to: ' . $email);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Password reset link sent to your email. If you don\'t see the email in your inbox, please check your spam or junk folder.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error sending password reset email: ', ['error' => $e->getMessage()]);

            // Redirect back with an error message
            return redirect()->back()->withErrors(['message' => 'Unable to send reset link']);
        }
    }

    public function updatePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'password'              => 'required|string|min:8|confirmed', // Ensure the password is confirmed
            'password_confirmation' => 'required|string|min:8',
            'email'                 => 'required|email', // Ensure the email is provided
        ]);

        // Assuming you get the user by the token passed in the URL
        $user = Merchant::where('email', $request->email)->first();

        if (! $user) {
            return redirect()->back()->withErrors(['message' => 'User not found.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect back with a success message
        return redirect()->route('merchant.login')->with('success', 'Your password has been reset successfully!');
    }

    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        return view('merchant-layout.auth.password_reset', compact('email'));
    }

    public function resendVerificationEmail( Request $request ) {
        $merchant = Auth::guard( 'merchant' )->user();

        if ( ! $merchant ) {
            return redirect()->route( 'merchant.login' )->withErrors( [ 'message' => 'You must be logged in to resend the verification email.' ] );
        }

        // Check if the merchant's email is already verified
        if ( $merchant->hasVerifiedEmail() ) {
            return redirect()->route( 'merchant.dashboard' )->with( 'success', 'Your email is already verified.' );
        }

        // Send the verification email
        $merchant->sendEmailVerificationNotification();

        return redirect()->route( 'merchant.verification.notice' )
            ->with( 'resend', 'Please check your email to verify your account.' );
    }

    public function logout( Request $request ) {
        // Handle merchant logout
        Auth::guard( 'merchant' )->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route( 'merchant.login' );
    }
}
