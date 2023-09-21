<?php

namespace App\Http\Controllers;

use App\Mail\ActivationEmail;
use App\Mail\activationmail;
use App\Mail\DeactivationEmail;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\FeedbackNotification;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //
    public function dashboard()
    {
        // Fetch only accepted reservations for the authenticated user
        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('Select...'), '');
        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $reservations = Reservation::where('status', 'accepted')->get();
        $events = [];

        $roomColors = [
            'Kifaru' => 'Orange',
            'Shark Tank Boardroom' => 'blue',
            'Executive Boardroom' => 'green',
            'Oracle Lab' => 'black',
            'Safaricom Lab' => 'black',
            'Ericsson Lab' => 'black',
            'Small Meeting Room' => 'purple',
            'Samsung Lab' => 'black'


            // Add more rooms and colors as needed
        ];


        foreach ($reservations as $reservation) {
            $roomName = $reservation->room->name;
            $color = $roomColors[$roomName] ?? 'gray'; // Default to gray if no color is defined
            $events[] = [
                'title' => $reservation->event,
                'start' => $reservation->reservationDate . 'T' . $reservation->reservationTime,
                'end' => $reservation->reservationDate . 'T' . $reservation->timelimit,
                'room' => $reservation->room->name,
                'color' => $color, // Assign the color based on the room

            ];
        }

        return view('user.dashboard', compact('events', 'reservations', 'roomColors'));
    }

    public function booking()
    {
        $rooms = Room::all();
        $items = Item::all();
        return view('user.booking', compact('rooms', 'items'));
    }
    public function reservation()
    {
        $user = auth()->user();
        $reservations = $user->reservations()->paginate(10); // Assuming you have defined a relationship in the User model      
        return view('user.reservation', compact('reservations'));
    }
    public function getAcceptedRooms()
    {
        $acceptedRooms = Room::where('status', 'accepted')->get();

        return $acceptedRooms;
    }
    public function showProfile()
    {
        return view('user.profile');
    }
    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            Alert::error('Error', 'Incorrect current password')->showConfirmButton('OK', '#3085d6');
            return redirect()->back();
        }

        // Check if the new password is too obvious (e.g., contains "password" or "123456")
        $obviousPasswords = ['password', '123456']; // Add more obvious passwords if needed
        if (in_array($request->new_password, $obviousPasswords)) {
            Alert::error('Error', 'Please choose a stronger password')->showConfirmButton('OK', '#3085d6');
            return redirect()->back();
        }

        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Display a success SweetAlert2 alert
        Alert::success('Success', 'Password changed successfully')->showConfirmButton('OK', '#3085d6');

        return redirect()->back();
    }

    public function reservationEnded($reservationId)
    {
        // Ensure the user is authenticated
        if (Auth::check()) {
            // Find the reservation by ID
            $reservation = Reservation::findOrFail($reservationId);

            // Check if the user is the owner of the reservation
            if ($reservation->user_id == Auth::user()->id) {
                // Send a notification to the user asking for feedback
                $user = Auth::user();
                $user->notify(new FeedbackNotification($reservation));

                // You can add additional logic here, such as marking the reservation as "ended"
                // or updating its status as needed.

                // Redirect the user to a thank you page or a feedback form
                return redirect()->route('feedback')->with('success', 'Thank you for your reservation. Please provide your feedback.');
            }
        }

        // Handle cases where the user is not authenticated or does not own the reservation
        return redirect()->route('welcome')->with('error', 'You are not authorized to provide feedback for this reservation.');
    }

    public function createUser(Request $request)
    {

        $fields = $request->validate([
            'id_number' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|unique:users,email',
            'roles' => 'required',
            'police_force_number' => 'nullable',
            'password' => 'required|confirmed'
        ]);


        // $token = Str::random(10) . $fields['id_number'];
        // $activateAccountLink = $request->getSchemeAndHttpHost() . "/api/activateAccount/" . $token;

        $email = $fields['email'];
        //Above is the mail you'd like to sent info to
        $data = array('activateAccountLink' => "activateAccountLink", 'name' => 'name data', 'email' => 'email data');


        try {
            Mail::send('mailadmin', $data, function ($message) use (&$email) {
                $message->to($email, 'Virtual Traffic Court')->subject('Registering Your Account.');
                $message->from('gradapp@strathmore.edu', 'Virtual Traffic Court');
            });



            //$user = Admin::create(['name' => $fields['first_name'], 'first_name' => $fields['first_name'], 'last_name' => $fields['last_name'], 'id_number' => $fields['id_number'], 'phone_number' => $fields['phone_number'], 'email' => $fields['email'], 'police_force_number' => isset($fields['police_force_number']) ? $fields['police_force_number'] : 'null', 'password' => Hash::make($fields['password']), 'remember_token' => $token]);


            // if (!is_null($user)) {
            //     $fields['roles'] = explode(',', $fields['roles']);

            //     $user_assign_role = $user->assignRole($fields['roles']);

            //     $token = $user->createToken('token-name');
            //     //return $token;


            //     return ["success" => "User Created Roles Assigned", "User" => $user_assign_role, "token" => $token->plainTextToken];
            // } else {
            //     return response()->json(["error" => "User Not Created"], 422);
            // }
        } catch (Exception $e) {
            return response()->json(
                [
                    "error" => " Exception Occured: User Not Created",
                    "Message" => $e->getMessage(),
                    "File" => $e->getFile(),
                    "LineNumber" => $e->getLine()
                ],
                422
            );
        }
    }
    public function activateUser(User $user)
    {
        // Check if the user is not already activated
        if (!$user->activated) {
            $user->activated = true;
            $user->save();

            // Send the activation email
            Mail::to($user)->send(new activationmail($user));

            return redirect()->back()->with('success', 'User activated successfully.');
        } else {
            return redirect()->back()->with('error', 'User is already activated.');
        }
    }
    public function deactivateUser(User $user)
    {
        if ($user->activated) {
            $user->activated = false;
            $user->save();
            Mail::to($user)->send(new DeactivationEmail($user));
            return redirect()->back()->with('success', 'User deactivated successfully.');
        } else {
            return redirect()->back()->with('error', 'User is already deactivated.');
        }
    }
}
