<?php
namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    public function login()
    {
        return view('users-layout.auth-login');
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

        // Attempt login with the provided credentials
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            session(['username' => $user->username]);

            // Redirect based on user role
            return match ($user->role) {
                0, 1    => redirect()->route('admin.dashboard'),
                2       => redirect()->route('dashboard'),
                default => redirect()->route('login'), // Default route if role is not matched
            };
        } else {
            // Log failed login attempt
            Log::warning('Failed login attempt', ['login' => $login]);
        }

        // Authentication failed
        return redirect(route('login'))->withErrors(['error' => 'Login details are not valid']);
    }

    public function registration()
    {
        return view('users-layout.auth-register');
    }

    public function registrationAction(Request $request)
    {
        // Validation rules for the form inputs
        $validator = Validator::make($request->all(), [
            'fname'     => 'required',
            'username'  => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'tel'       => [
                'required',
                'max:20',
                'min:6',
                'unique:users',
            ], // Corrected the comma issue here
            'address'   => 'required',
            'password'  => 'required|max:20|min:6',
            'cpassword' => 'required|same:password',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Default values for user registration
        $role           = 2;
        $refferal_user  = $request->input('referral'); // Get referral username from the request
        $refferal       = 0;
        $refferal_bonus = 0.0;
        $cal            = 1;

                                                                  // Generate a unique user_id
        $randomString = strtoupper(substr(md5(mt_rand()), 0, 8)); // Generate a random 8-character string
        $latestUserId = User::max('id') + 1;                      // Fetch the next auto-increment ID
        $userId       = 'UID' . $randomString . $latestUserId;    // Combine strings to form a unique user ID

        // Data array for creating a new user
        $data = [
            'name'           => $request->fname,
            'user_id'        => $userId, // Assign the generated user_id
            'username'       => $request->username,
            'address'        => $request->address,
            'email'          => $request->email,
            'tel'            => $request->tel,
            'password'       => Hash::make($request->password),
            'role'           => $role,
            'cal'            => $cal,
            'refferal_user'  => $refferal_user ?? null, // Set nullable if referral user is not provided
            'refferal'       => $refferal,
            'refferal_bonus' => $refferal_bonus,
        ];

        // Create the user
        $user = User::create($data);

        if ($user) {
            // Handle referral logic if there's a referral user
            if ($refferal_user) {
                $referrer = User::where('user_id', $refferal_user)->first();

                if ($referrer) {

                    $referrer->increment('refferal');

                    // Create referral record
                    Referral::create([
                        'user_id'           => $referrer->user_id, // ID of the referring user
                        'referral_user_id'  => $user->user_id,     // ID of the referred user
                        'referral_username' => $user->username,    // Referred user's username
                    ]);
                }
            }

            // Redirect to the login page with success message
            return redirect(route('login'))->with('success', 'Registration successful, login to access the dashboard.');
        } else {
            // Redirect to the registration page with error message
            return redirect(route('registration'))->with('error', 'Registration failed, try again.');
        }
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
        return redirect(route('login'));
    }
}
