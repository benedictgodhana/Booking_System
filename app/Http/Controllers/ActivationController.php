<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivationController extends Controller
{
    public function activateAccount($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            // Handle invalid or expired activation token (e.g., show an error message)
            return view('activation_error');
        }

        // Activate the user's account
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        // Log in the user (optional)
        auth()->login($user);

        // Redirect to a success page or show a message
        return view('activation_success');
    }
    public function sendActivationEmail(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('account.activation')->with('error', 'Account not found.');
        }

        if ($user->activated) {
            return redirect()->route('login')->with('status', 'Your account is already activated. You can log in.');
        }

        // Generate and set a new activation token
        $token = Str::random(60);        
        $user->activation_token = $token;
        $user->save();

        // Send activation email here (you should implement this)

        return redirect()->route('login')->with('status', 'Activation email sent. Please check your email to activate your account.');
    }

}
