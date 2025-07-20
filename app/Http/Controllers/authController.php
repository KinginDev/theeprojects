<?php
namespace App\Http\Controllers;

use App\Classes\Helper;
use App\Models\Merchant;
use App\Models\MerchantUser;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('users-layout.auth.login');
    }

    public function loginAction(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'emailTel' => 'required',
            'password' => 'required',
        ]);

        $login    = $request->input('emailTel');
        $password = $request->input('password');

        // Determine if input is email, phone number, or username
        $isEmail       = filter_var($login, FILTER_VALIDATE_EMAIL);
        $isPhoneNumber = preg_match('/^\d+$/', $login); // Assumes a valid phone number is numeric
        $isUsername    = ! $isEmail && ! $isPhoneNumber;  // Assume username if neither email nor phone number

        if ($isEmail) {
            $credentials = ['email' => $login, 'password' => $password];
        } elseif ($isPhoneNumber) {
            $credentials = ['tel' => $login, 'password' => $password];
        } else {
            $credentials = ['username' => $login, 'password' => $password];
        }

         $remember = $request->boolean('remember', false);

        // Attempt login with the provided credentials
        if (! Auth::guard('web')->attempt($credentials, $remember)) {
            // Authentication successful

            return redirect(route('users.login',[
            'slug' => Helper::merchant()->slug,
        ]))->withErrors(['error' => 'Login details are not valid']);
        }

        $user = User::find(Auth::guard('web')->id());

        $user->update([
            'remember_token' => $request->input('remember') ? Hash::make($user->email . $user->password) : null,
        ]);

        $user = Auth::guard('web')->user();
        session(['username' => $user->username]);
        return redirect()->route('users.dashboard', [
            'slug' => Helper::merchant()->slug,
        ])->with('success', 'Login successful!');

    }

    public function registration()
    {
        return view('users-layout.auth.register');
    }

    public function registrationAction(Request $request)
    {
        // Validation rules for the form inputs
        $validator = Validator::make($request->all(), [
            'fname'       => 'required',
            'username'    => 'required|unique:users',
            'email'       => 'required|email|unique:users',
            'tel'         => [
                'unique:users',
            ],
            'address'     => 'required',
            'password'    => 'required|max:20|min:6|confirmed',
            'terms'       => 'accepted',
            'merchant_id' => 'nullable|exists:merchants,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Default values for user registration
        $role           = 2;
        $refferal_user  = $request->input('referral');
        $refferal       = 0;
        $refferal_bonus = 0.0;
        $cal            = 1;

        $randomString = strtoupper(substr(md5(mt_rand()), 0, 8));
        $latestUserId = User::max('id') + 1;
        $referrerId   = "UID{$randomString}{$latestUserId}";

        // Data array for creating a new user
        $data = [
            'name'            => $request->fname,
            'referrer_id'     => $referrerId,
            'username'        => $request->username,
            'address'         => $request->address,
            'email'           => $request->email,
            'tel'             => $request->tel,
            'password'        => Hash::make($request->password),
            'role'            => $role,
            'cal'             => $cal,
            'refferal_user'   => $refferal_user ?? null,
            'refferal'        => $refferal,
            'refferal_bonus'  => $refferal_bonus,
            'smart_earners'  => 0.0,
            'api_earners'    => 0.0,
            'topuser_earners' => 0.0,
        ];

        // Create the user
        $user = User::create($data);

        event (new Registered($user));

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Failed to create account. Please try again.'])->withInput();
        }

        // Handle referral logic if there's a referral user
        if ($refferal_user) {
            $referrer = User::where('username', $refferal_user)->first();
            if ($referrer) {
                Referral::create([
                    'referrer_id'       => $referrer->id,
                    'referred_id'       => $user->id,
                    'referral_username' => $user->username,
                ]);
            }
        }

        $merchant = Helper::merchant();
        if (!$merchant) {
            $merchant = Merchant::where('slug', $request->merchant_slug)->first();
        }

        // Check if the user is associated with a merchant
        $merchantUser = MerchantUser::where('user_id', $user->id)
            ->where('merchant_id', $merchant->id)
            ->first();

        if (!$merchantUser) {
            MerchantUser::create([
                'merchant_id' => $merchant->id,
                'user_id'     => $user->id,
            ]);
        }

        // Send email verification notification
        event(new Registered($user));

        Auth::guard('web')->login($user);

        return redirect(route('users.verification.notice', [
            'slug' => $merchant->slug,
        ]))->with('resend', 'Please check your email to verify your account.');
    }

    public function forget_password()
    {
        return view('users-layout.forget_password');
    }

    public function forgetPasswordMail(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);

        // Get the user's email from the request
        $email = $request->input('email');

        // Check if the user exists in the database
        $user = User::where('email', $email)->first();

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
            <p><a href='" . route('password.reset', ['token' => $token, 'email' => $email]) . "'>Reset Password</a></p>
            <p>If you did not request a password reset, please ignore this email.</p>
        </body>
    </html>";

        // Send an email notification to the user
        try {
            Mail::send([], [], function ($mail) use ($email, $htmlContent) {
                $mail->to($email)                   // Send to the user's email
                    ->subject('Password Reset Request') // Subject of the email
                    ->html($htmlContent);               // Use the html() method to set the HTML body
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
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return redirect()->back()->withErrors(['message' => 'User not found.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect back with a success message
        return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
    }

    /**
     * Send a verification email to the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendVerificationEmail(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (! $user) {
            return redirect()->back()->withErrors(['message' => 'You must be logged in to request a verification email.']);
        }

        if($user->hasVerifiedEmail()) {
            return redirect()->route('users.dashboard', [
                'slug' => Helper::merchant()->slug,
            ])->with('message', 'Your email is already verified.');
        }

        // Send the email verification notification
        $user->sendEmailVerificationNotification();

        return back()->with('resent', 'Verification link sent to your email.');
    }

    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        return view('users-layout.password_reset', compact('email'));
    }

    public function logout()
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session
        session()->invalidate();

        // Regenerate the CSRF token to prevent session fixation
        session()->regenerateToken();

        // Redirect the user to the login page
        return redirect(route('home'))->with('success', 'You have been logged out successfully.');
    }
}
