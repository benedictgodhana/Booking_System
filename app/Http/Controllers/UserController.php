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
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use TCPDF;

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
        $reservations = $user->reservations()->paginate(7); // Assuming you have defined a relationship in the User model      
        return view('user.reservation', compact('reservations'));
    }
    public function getAcceptedRooms()
    {
        $acceptedRooms = Room::where('status', 'accepted')->get();

        return $acceptedRooms;
    }
    public function showProfile()
    {
        $user = User::find(auth()->id()); // Assuming you're using authentication
        return view('user.profile',['user' => $user]);
    }
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:8',
            'new_password_confirmation' => 'nullable|same:new_password',
            'contact' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

       // Check if the current password is provided and matches the authenticated user's password
if ($request->current_password && !Hash::check($request->current_password, Auth::user()->password)) {
    return redirect()->back()->with('error', 'Incorrect current password');
}

// Check if the new password is provided and is too obvious (e.g., contains "password" or "123456")
$obviousPasswords = ['password', '123456']; // Add more obvious passwords if needed
if ($request->new_password && in_array($request->new_password, $obviousPasswords)) {
    return redirect()->back()->with('error', 'Please choose a stronger password');
}

        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->department = $request->input('department') === 'Others'
        ? $request->input('other_department') // Use "other_department" if "Others" selected
        : $request->input('department'); // Use the selected department
        $user->contact = $request->input('contact');
        $user->save();

        return redirect()->back()->with('success', 'User Profile updated Successfully');
  
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
    public function checkActivation(Request $request)
{
    // Get the user's email from the request
    $email = $request->input('email');

    // Find the user by their email
    $user = User::where('email', $email)->first();

    if (!$user) {
        // User with the provided email not found
        return redirect()->back()->with('error', 'User not found. Kindly Contact IT Admin at Ilab');
    }

    // Check if the user is activated (assuming 'is_active' is a boolean field in the database)
    if ($user->activated) {
        // User is already activated
        return redirect()->back()->with('status', 'Your account is already activated. You can now log in.');
    }

    // Check if the user is marked as a guest (is_guest is 1)
    if ($user->is_guest === 1) {
        return redirect()->back()->with('error', 'Guests cannot activate accounts.');
    }

    $token = Str::random(60);

    // Store the token in the database or an activation table (you can add an 'activation_token' field to the 'users' table)
    $user->update(['activation_token' => $token]);

    if (!$user) {
        // Handle invalid or expired activation token (e.g., show an error message)
        return view('activation_error');
    }

    // Activate the user's account
    $user->activated = true;
    $user->save();

    // Log in the user (optional)

    // Send an activation email with the token
    Mail::to($user->email)->send(new ActivationMail($user, $token));

    // Send an activation link or perform the activation process here

    // After sending the activation link, you can notify the user accordingly
    return redirect()->back()->with('status', 'Your Account Has been Activated. Please check your inbox for login credentials.');
}

public function searchReservations(Request $request)
{
    // Retrieve the form inputs
    $searchTerm = $request->input('search');
    $statusFilter = $request->input('status');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query reservations based on the filters
    $query = Reservation::query();

    // Apply filters based on the form inputs
    if (!empty($searchTerm)) {
        $query->where(function ($q) use ($searchTerm) {
            $q->where('event', 'like', "%$searchTerm%")
                ->orWhere('remarks', 'like', "%$searchTerm%");
        });
    }

    if (!empty($statusFilter)) {
        $query->where('status', $statusFilter);
    }

    if (!empty($startDate)) {
        $query->whereDate('reservationDate', '>=', $startDate);
    }

    if (!empty($endDate)) {
        $query->whereDate('reservationDate', '<=', $endDate);
    }

    // Retrieve the filtered reservations
    $reservations = $query->paginate(7); // Adjust the pagination as needed

    // Define the $isTimeLimitPassed variable here
    $isTimeLimitPassed = [];

    foreach ($reservations as $reservation) {
        // Calculate $isTimeLimitPassed for each reservation
        $currentDate = \Carbon\Carbon::now();
        $currentDateTime = \Carbon\Carbon::now();
        $reservationDate = \Carbon\Carbon::parse($reservation->reservationDate);
        $timeLimit = \Carbon\Carbon::parse($reservation->timelimit);
        
        // Compare the current date with the reservation date
        $isDatePassed = $currentDate->gt($reservationDate);
        $isTimeLimitPassed[$reservation->id] = $currentDateTime->gt($timeLimit);
    }

    // Pass $isTimeLimitPassed to the view along with $reservations
    return view('user.search_results', ['reservations' => $reservations, 'isTimeLimitPassed' => $isTimeLimitPassed]);
}
public function updateProfile(Request $request)
{
    // Validate the form data
    $request->validate([
        'inputUsername' => 'required|string|max:255',
        'inputOrgName' => 'required|string|max:255',
        'inputLocation' => 'required|string|max:255',
        'inputEmailAddress' => 'required|email|unique:users,email,' . Auth::id(),
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Update the user's profile information
    $user->name = $request->input('inputUsername');
    $user->department = $request->input('inputOrgName');
    $user->roles->name = $request->input('inputLocation');
    $user->email = $request->input('inputEmailAddress');

    // Save the updated user
    $user->save();

    // Redirect back to the profile page with a success message
    return redirect()->route('profile.index')->with('success', 'Profile information updated successfully.');
}

public function generateUserGuidePdf()
{
    // Create a new TCPDF instance
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('User Guide');
    $pdf->SetSubject('User Guide');
    $pdf->SetKeywords('User Guide, Room Booking');

    // Set page format (e.g., A4)
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage();

    // Render the HTML content (userguide.blade.php) into a variable
    $html = view('userguide')->render();
    // Output the HTML content onto the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF (you can save or stream it)
    $pdf->Output('user_guide.pdf', 'I');
}
}
    