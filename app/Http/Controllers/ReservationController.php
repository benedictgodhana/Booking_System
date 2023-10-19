<?php

namespace App\Http\Controllers;

use App\Rules\RoomAvailability;
use App\Jobs\SendAdminReservationNotification;
use App\Jobs\SendMiniAdminReservationNotification;
use App\Jobs\SendSubAdminReservationNotification;
use App\Jobs\SendUserReservationNotification;
use App\Mail\AdmReservationCreated;
use App\Mail\MiniAdminReservationCreated;
use App\Mail\ReservationConfirmationMail;
use App\Mail\ReservationCreated;
use App\Mail\SubReservationCreated;
use App\Models\Activity;
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\AdminReservationNotification;
use App\Notifications\AdmReservationCreated as NotificationsAdmReservationCreated;
use App\Notifications\BookingAcceptedNotification;
use App\Notifications\BookingDeclinedNotification;
use App\Notifications\MiniAdminReservationNotification;
use App\Notifications\SubAdminReservationNotification;
use App\Notifications\SuperAdminReservationNotification;
use App\Notifications\UserReservationNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data, including the RoomAvailability rule
        $validatedData = $request->validate([
            'capacity' => 'required|integer',
            'selectRoom' => 'required|exists:rooms,id',
            'reservationDate' => 'required|date',
            'reservationTime' => 'required',
            'duration' => 'required|integer',
            'event' => 'nullable|string',
            'itServices' => 'boolean',
            'setupAssistance' => 'boolean',
            'requestItems' => 'boolean',
            'itemRequests' => 'nullable|array', // Make the itemRequests field optional            
            'itemRequests.*' => 'exists:items,id', // Validate each item in the array           
            'comment' => 'nullable|string', // Comment field is optional
            'selectRoom' => [
                'required',
                'exists:rooms,id',
                // Use the RoomAvailability rule here
                new RoomAvailability(
                    $request->input('selectRoom'),
                    $request->input('reservationDate'),
                    $request->input('reservationTime')
                ),
            ],
        ]);
    
        // The rest of your code remains the same
    
        // Calculate the end time based on reservation time and duration
        $startTime = strtotime($validatedData['reservationTime']);
        $endTime = date('H:i', strtotime("+" . $validatedData['duration'] . " hours", $startTime));
    
        // Create a new reservation instance
        $reservation = new Reservation();
        $reservation->user_id = auth()->user()->id; // Assuming you're using authentication
        $reservation->room_id = $validatedData['selectRoom'];
        $reservation->reservationDate = $validatedData['reservationDate'];
        $reservation->reservationTime = $validatedData['reservationTime'];
        $reservation->timelimit = $endTime; // Store the calculated end time
        $reservation->capacity = $validatedData['capacity'];
        $reservation->event = $validatedData['event'];
        $reservation->itServices = $validatedData['itServices'] ?? false;
        $reservation->setupAssistance = $validatedData['setupAssistance'] ?? false;
        $reservation->comment = $validatedData['comment'];
    
        // Save the reservation to the database
        $reservation->save();

        if (isset($validatedData['itemRequests'])) {
            $reservation->items()->attach($validatedData['itemRequests']);
        }
        
    
        // If items were requested, attach them to the reservation
            // Send notifications to different user roles (SuperAdmin, Admin, MiniAdmin, User)

        Activity::create([
            'user_id' => auth()->user()->id, // The ID of the authenticated user
            'action' => 'Reservation Created', // Log the action
            'description' => 'New reservation created by ' . auth()->user()->name, // Include relevant information
        ]);

        // Send an email notification to user upon reservation
        $roomName = $reservation->room->name;
        $reservationDate = Carbon::parse($reservation->reservationDate); // Use the date from the reservation object
        $reservationTime = Carbon::parse($reservation->reservationTime)->format('h:i A'); // Format time as "h:i A"
        $timelimit = Carbon::parse($reservation->timelimit)->format('h:i A'); // Format timelimit as "h:i A"
        $Event = $reservation->event;
        $userName = auth()->user()->name;

        Mail::send('emails.reservation', [
            'userName' => $userName,
            'roomName' => $roomName,
            'reservationDate' => $reservationDate,
            'reservationTime' => $reservationTime,
            'EndReservation' => $timelimit,
            'Event' => $reservation->event,
            'Comments'=>$reservation->comment,
            'viewReservationUrl' => url('/user/reservations'),

            // Add other email variables here
        ], function ($message) {
            $message->to(auth()->user()->email)->subject('Reservation Confirmation');
        });

        // for superadmin Notification
        // $superAdmin = User::where('role', 1)->first();
        // if ($superAdmin) {
        //     $superAdminName = $superAdmin->name;

        //     if ($superAdmin) {
        //         Mail::to($superAdmin->email)->send(new ReservationCreated($reservation, $superAdminName));
        //     }

            //for subadmin Notification 
            $subAdmins = User::where('role', 2)->get();

            foreach ($subAdmins as $subAdmin) {
                $subAdminName = $subAdmin->name;

                Mail::to($subAdmin->email)->send(new SubReservationCreated($reservation, $subAdminName));
            }

            //for Admin Notification
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

                //for Admin Notification
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


                    session()->flash('success', 'Reservation request has been sent successfully. Please wait for confirmation.');



                    return back();
                }

                return 'No reservations found for rooms 2 and 3.';
            }
        }
    

    public function updateReservationStatus(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'status' => 'required|in:Accepted,Declined',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Find the reservation by ID
        $reservation = Reservation::findOrFail($id);

        // Update the reservation status and remarks
        $reservation->status = $validatedData['status'];
        $reservation->remarks = $validatedData['remarks'];

        $reservation->save();


        // Save the changes to the database

        if ($request->status === 'Accepted') {
            // Notify the user that the booking has been accepted
            $reservation->user->notify(new BookingAcceptedNotification($reservation));
        } elseif ($request->status === 'Declined') {
            // Notify the user that the booking has been declined and include a remark
            $reservation->user->notify(new BookingDeclinedNotification($reservation, $request->remark));
        }



        // Redirect back to the reservation status page with a success message
        return redirect()->back()->with('success', 'Reservation status updated successfully.');
    }

    public function index()
    {
        $reservations = Reservation::all();
        $events = [];
    
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => $reservation->event, // Use the event details
                'start' => $reservation->reservationDate . 'T' . $reservation->reservationTime,
                'end' => $reservation->reservationDate . 'T' . $reservation->endTime,
                'room' => $reservation->room->name,
            ];
        }
    
        return view('events.index', compact('events'));
    }
    

        public function filterPendingReservations(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Perform the filtering query for pending reservations based on the date created
        $filteredReservations = Reservation::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Pending') // Adjust this condition as needed
            ->orderBy('created_at', 'asc') // You can adjust the sorting as needed
            ->get();

        // Return the filtered reservations as JSON response
        return response()->json(['reservations' => $filteredReservations]);
    }

 public  function cancelReservation($id)
{
    // Your cancellation logic here
    // For example, you can update the reservation status to "Canceled"

    $reservation = Reservation::find($id);
    if ($reservation) {
        $reservation->update([
            'status' => 'Canceled',
        ]);

        // You can also add any additional logic here, such as sending notifications, etc.

        return redirect()->back()->with('success', 'Reservation has been canceled successfully.');
    }

}
}
