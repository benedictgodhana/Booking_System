<?php

namespace App\Http\Controllers;

use App\Mail\AdmReservationCreated;
use App\Mail\GuestAdminNotificationMail;
use App\Mail\GuestMiniAdminNotificationMail;
use App\Mail\GuestReservationConfirmationMail;
use App\Mail\GuestSubadminNotificationMail;
use App\Mail\GuestSuperadminNotificationMail;
use App\Mail\MiniAdminReservationCreated;
use App\Mail\ReservationRequest;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str; // Import the Str class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GuestBookingController extends Controller
{
    public function showForm()
    {
        $rooms = Room::all();
        $items = Item::all();
        return view('guest.booking', compact('rooms', 'items'));
    }

    public function submitBooking(Request $request)
    {
    // Validate the form input        'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[A-Za-z0-9._%+-]+@strathmore\.edu$/i'],
       // Validate the request data
$validatedData = $request->validate([
    'guest_name' => 'required|string|max:255',
    'guest_email' => 'required|email|regex:/^[A-Za-z0-9._%+-]+@strathmore\.edu$/i',
    'room' => 'required|exists:rooms,id',
    'booking_date' => 'required|date',
    'booking_time' => 'required|date_format:H:i',
    'duration' => 'required|integer',
    'item_id' => 'nullable|exists:items,id',
    'guest_department' => 'nullable|string|max:255', // Add department validation
    'event' => 'nullable|string', // Add validation for event   
]);

$email = $request->input('guest_email');
$existingUser = User::where('email', $email)->first();

if ($existingUser) {
    // An account with this email already exists, so create a reservation for the existing user
    $guestUser = $existingUser;
} else {
    // Create a new guest user
    $guestUser = new User();
    $guestUser->name = $request->input('guest_name');
    $guestUser->email = $request->input('guest_email');
    $guestUser->password = bcrypt(Str::random(16)); // Generate a random password        
    $guestUser->is_guest = true; // Set the user as a guest
    $guestUser->department = $request->input('guest_department'); // Capture the guest's department
    $guestUser->save();
}

// Calculate the end time based on the start time and duration
$startTime = strtotime($validatedData['booking_time']);
$endTime = date('H:i', strtotime("+" . $validatedData['duration'] . " hours", $startTime));

// Create a new reservation for the guest user
$reservation = new Reservation();
$reservation->user_id = $guestUser->id; // Associate the reservation with the guest user
$reservation->room_id = $request->input('room');
$reservation->item_id = $request->input('item_id');
$reservation->reservationDate = $request->input('booking_date');
$reservation->reservationTime = $request->input('booking_time');
$reservation->timelimit = $endTime; // Store the calculated end time
$reservation->event = $request->input('event');

// Process checkboxes or fields related to IT services, setup assistance, and item requests
$reservation->itServices = $request->input('it_services_requested', false);
$reservation->setupAssistance = $request->input('setup_assistance_requested', false);
$reservation->requestItems = $request->input('item_requests',false);

$reservation->save();

// Include selected items (assuming you have the logic to determine selected items)
$selectedItems = [
    'Item 1',
    'Item 2',
    'Item 3',
    // Add more items as needed
];

// Retrieve the reservation details and assign them to variables
$userName = $reservation->user->name;
$selectedRoom = $reservation->room->name;
$reservationDate = $reservation->reservationDate;
$reservationTime = Carbon::parse($reservation->reservationTime)->format('h:i A');
$duration = Carbon::parse($reservation->timelimit)->format('h:i A');
$event = $reservation->event;
$itServicesRequested = $reservation->itServicesRequested;
$setupAssistanceRequested = $reservation->setupAssistanceRequested;
$itemRequests = $reservation->itemRequests;

// Check if at least one checkbox is checked or itemRequests is not empty
if ($itServicesRequested || $setupAssistanceRequested || !empty($itemRequests)) {
    // Send the email with the reservation details
    Mail::to('ilabsupport@strathmore.edu')->send(new ReservationRequest(
        $userName,
        $selectedRoom,
        $reservationDate,
        $reservationTime,
        $duration,
        $event,
        $itServicesRequested,
        $setupAssistanceRequested,
        $itemRequests,
        $selectedItems
    ));
}


        $data = [
            'guest_name' => $guestUser->name,
            'room_name' => $reservation->room->name, // Replace with your actual room variable
            'reservation_date' => $request->input('booking_date'),
            'reservation_time' => date("h:i A", strtotime($request->input('booking_time'))), // Format as AM/PM
            'timelimit' => date("h:i A", strtotime($request->input('timelimit'))), // Format as AM/PM
            'department' => $guestUser->department,
            'event' => $reservation->event,
            'selectedItems' => $selectedItems, // Include selectedItems


            // Add more reservation details as needed
        ];

        // Send the email confirmation to the guest user
        Mail::to($guestUser->email)
            ->send(new GuestReservationConfirmationMail($data));

        //Notification to SuperAdmin
        $superadmins = User::where('role', 1)->get();
        // Send the email notification to each superadmin
        foreach ($superadmins as $superadmin) {
            $superadminEmail = $superadmin->email;
            $superadminName = $superadmin->name; // Replace with your logic to retrieve the Superadmin's name.

            Mail::to($superadminEmail)
                ->send(new GuestSuperadminNotificationMail($data, $superadminName));

            //Notification to SubAdmin
            if ($request->input('room') == 1) {
                // Get the subadmin's name (you should replace this with your actual subadmin retrieval logic)

                // Notify the subadmin and pass the subadmin's name as a parameter
                $subadmin = User::where('role', 2)->first(); // Assuming subadmin role is 2
                $subadminName = $subadmin->name;
                $subadminEmail = $subadmin->email; // Example: Replace with the actual subadmin's name
                Mail::to($subadminEmail)
                    ->send(new GuestSubadminNotificationMail($data, $subadminName));
            }

            //Notification to Admin

            $reservations = Reservation::whereIn('room_id', [2, 3])->get();

            if ($reservations->count() > 0) {
                // Get all admin users with role ID 3
                $admins = User::where('role', 3)->get();

                // Loop through admin users and send emails
                foreach ($admins as $admin) {                    // Customize the email subject and content as needed
                    $subject = 'New Reservation Created';
                    $content = 'A new reservation has been created for rooms 2 and 3.';
                    // Send the email
                    Mail::to($admin->email)->send(new AdmReservationCreated($reservations, $admin->name));
                }
            }

            //Notification to MiniAdmin
            $reservations = Reservation::whereIn('room_id', [4, 5, 6, 7, 8])->get();

            if ($reservations->count() > 0) {
                // Get all admin users with role ID 3
                $miniadmins = User::where('role', 4)->get();

                // Loop through admin users and send emails
                foreach ($miniadmins as $miniadmin) {                    // Customize the email subject and content as needed
                    $subject = 'New Reservation Created';
                    $content = 'A new reservation has been created for rooms 2 and 3.';
                    // Send the email
                    Mail::to($miniadmin->email)->send(new MiniAdminReservationCreated($reservations, $miniadmin->name));
                }
            }
        }

        return view('guest.thankyou');
    }


    public function thankYou()
    {
        return view('guest.thankyou'); // Replace 'guest.thankyou' with your actual view name
    }
}
