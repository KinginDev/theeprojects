<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Setting;
use App\Models\UserMessage;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class SettingController extends Controller
{
    public function usersetting()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();


            // Pass the data and the flag to the view
            return view('users-layout.dashboard.setting', [
                'userData' => $userData,
                'notifications' => $notifications,
            ]);
        }
    }



    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:15',
            'address' => 'required|string',
            'oldpassword' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        // Add a validation failure message if the current password is incorrect
                        $fail('The current password is incorrect.');
                    }
                },
            ],
            'password' => 'nullable|confirmed|min:6', // Validate password confirmation
        ]);

        // Find the user
        $user = User::findOrFail($id);

        // Update user attributes
        $user->name = $validatedData['name'];
        $user->tel = $validatedData['tel'];
        $user->address = $validatedData['address'];

        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Save the user
        $user->save();

        // Redirect with a success message
        return redirect()->route('user.setting')
            ->with('success', 'User updated successfully.');
    }

    public function usersupport()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();


            // Pass the data and the flag to the view
            return view('users-layout.dashboard.support', [
                'userData' => $userData,
                'notifications' => $notifications,
            ]);
        }
    }

    public function send_message(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create a new message record in the database
        UserMessage::create([
            'username' => $request->username,
            'message' => $request->message,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully! Admin will reply within 24 hours.');
    }

    public function send_email(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            // Create a new message record in the database
            $message = UserMessage::create([
                'username' => $request->email, // Assuming 'username' is used as the email
                'message' => $request->message,
            ]);

            // Log that the message was created successfully
            Log::info('Message created successfully: ', ['username' => $message->username, 'message' => $message->message]);

            // Get settings
            $configuration = Setting::first();

            // Prepare HTML content
            $htmlContent = "<html>
            <body>
                <h1>Message from: {$request->email}</h1>
                <p><strong>Subject:</strong> {$request->subject}</p>
                <p><strong>Message:</strong></p>
                <p>{$request->message}</p>
            </body>
        </html>";

            // Send an email notification to the admin
            Mail::send([], [], function ($mail) use ($configuration, $request, $htmlContent) {
                $mail->to($configuration->email)
                    ->subject($request->subject)
                    ->html($htmlContent); // Use the html() method to set the HTML body
            });

            // Log that the email was sent successfully
            Log::info('Email sent successfully to: ' . $configuration->email);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Your message has been sent successfully! Admin will reply within 24 hours.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in send_email: ', ['error' => $e->getMessage()]);

            // Return a 500 error response
            return response()->view('errors.500', [], 500);
        }
    }
}
