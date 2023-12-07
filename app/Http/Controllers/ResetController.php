<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    public function showResetForm()
    {
        // Add any additional logic or data needed for the reset form view
        return view('auth.custom_reset');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
    
        // Check if the user is authenticated
        if (!Auth::check()) {
            // User is not authenticated, redirect to login or return an error response
            return redirect()->route('LoginPage')->withErrors(['login' => 'Please log in to update your password']);
        }
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Check if the provided current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Incorrect current password']);
        }
    
        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();
    
        // Log the user out
        Auth::logout();
    
        // Flash a message to inform the user about the password update
        return redirect()->route('LoginPage')->with('success', 'Password updated successfully. Please log in with your new credentials.');
    }
    
    // Your redirectDash method remains unchanged
    
public function redirectDash()
{
    $redirect = '';

    if (Auth::user() && Auth::user()->role == 1) {
        $redirect = '/super-admin/dashboard';
    } else if (Auth::user() && Auth::user()->role == 2) {
        $redirect = '/sub-admin/dashboard';
    } else if (Auth::user() && Auth::user()->role == 3) {
        $redirect = '/admin/dashboard';
    } else if (Auth::user() && Auth::user()->role == 4) {
        $redirect = '/miniadmin/dashboard';
    } else {
        $redirect = '/dashboard';
    }

    return $redirect;
}

}
