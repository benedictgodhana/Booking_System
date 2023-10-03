<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use RealRashid\SweetAlert\Facades\Alert;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('passwords_request');
    }
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Find the user by their email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => __('User not found.')]);
    }

    // Check if the user is marked as a guest (is_guest is 1)
    if ($user->is_guest === 1) {
        return back()->withErrors(['email' => __('Guests cannot request a password reset.')]);
    }

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('status', 'Password reset link has been sent to your email.');
    } else {
        return back()->withErrors(['email' => __($status)]);
    }
}


    // Show the form to reset a user's password.
    public function showResetForm(Request $request, $token = null)
    {
        return view('passwords_reset')->with(['token' => $token, 'email' => $request->email]);
    }

    // Reset the given user's password.
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            // Show a SweetAlert on success

            return redirect()->back()->with('status', 'Password has been reset successfully. You can now log in with your new password.');
        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }
}
