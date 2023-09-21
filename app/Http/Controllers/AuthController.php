<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Notifications\UserRegisteredNotification;
use App\Notifications\UserLoggedInNotification; // Import the notification class

// ...

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required'
        ]);

       
    }
    public function loadDashboard()
    {
        return view('user.dashboard');
    }


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

    public function logout(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Log the logout activity
        Activity::create([
            'user_id' => $user->id,
            'action' => 'User Logged Out',
            'description' => 'User ' . $user->name . ' logged out',
        ]);

        $request->session()->flush();
        Auth::logout();

        return redirect('/');
    }
    public function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userCredential = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($userCredential)) {
            // Check if the user is activated
            $user = Auth::user();

            if ($user->activated) {
                // User is activated, proceed with login
                $route = $this->redirectDash();
                return response()->json(['success' => true, 'redirectTo' => $route]);
            } else {
                // User is not activated, log them out and return an error message
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'Your account is not activated.']);
            }
        } else {
            // Authentication failed
            return response()->json(['success' => false, 'message' => 'Username & Password is incorrect']);
        }
    }


    public function loadLogin()
    {
        if (Auth::user()) {
            $route = $this->redirectDash();
            return redirect($route);
        }

        // Store the previous URL in the session
        Session::put('previous_url', url()->previous());

        $user = Auth::user(); // Retrieve the authenticated user
                return view('login',compact('user'));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            // Get the user data from Google
            $googleUser = Socialite::driver('google')->user();

            // Check if the user already exists in your database
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                // If the user doesn't exist, create a new user
                $user = new User();
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                // You can set other user attributes here as needed
                $user->save();
            }

            // Log in the user
            Auth::login($user);

            Activity::create([
                'user_id' => $user->id,
                'action' => 'User Logged In',
                'description' => 'User ' . $user->name . ' logged in using Google',
            ]);

            // Send a notification to the user
            $user->notify(new UserLoggedInNotification());

            // Redirect the user to the previous URL or the dashboard
            $previousUrl = Session::get('previous_url', '/dashboard');
            Session::forget('previous_url'); // Clear the stored URL
            return redirect($previousUrl);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the login process
            return redirect('/login')->with('error', 'Google login failed.');
        }
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        // Check if the user is authenticated and activated
        if ($user && $user->activated) {
            // Add logic to handle password change and logout
            // Once the password is changed, log the user out and redirect to login
            if ($request->isMethod('post')) {
                // Validate and update the password
                $request->validate([
                    'new_password' => 'required|min:8',
                ]);

                $user->password = Hash::make($request->input('new_password'));
                $user->save();

                Auth::logout();
                Alert::success('Success', 'Password changed successfully. Please log in with your new password.');
                return redirect()->route('login'); // Change to the appropriate route name
            }

            // Render the password change form
            return view('change_password');
        } else {
            // User is not authenticated or not activated
            Alert::error('Error', 'Invalid request.');
            return redirect()->route('login'); // Change to the appropriate route name
        }
    }
    public function activateAccount(Request $request, User $user)
    {
        // Check if the provided activation token is valid
        if ($request->has('token') && $request->token === $user->activation_token) {
            // Mark the user as activated
            $user->activated = true;
            $user->save();

            // Log the user in and prompt them to change their password
            Auth::login($user);
            return redirect()->route('change-password'); // Change to the appropriate route name
        } else {
            Alert::error('Error', 'Invalid activation token.');
            return back();
        }
    }
}
