<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Department;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\BookingAcceptedNotification;
use App\Notifications\BookingDeclinedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class SubAdminController extends Controller
{
    //
    public function dashboard()
    {
        $events = [];
        $reservations = Reservation::where('status', 'accepted')->get();
        $roomID=[1];
        // Filter reservations for accepted rooms only
        $subadminRoomIDs = [1, 2, 3, 4, 5, 6, 7, 8]; // Replace with the IDs of rooms accepted by the admin
        $acceptedReservations = $reservations->filter(function ($reservation) use ($subadminRoomIDs) {
            return in_array($reservation->room_id, $subadminRoomIDs);
        });

        $reservationsAcceptedCount = Reservation::whereIn('room_id', $roomID)
        ->where('status', 'Accepted')
        ->count();        
        $pendingReservationsCount = Reservation::whereIn('room_id', $roomID)
        ->where('status', 'Pending')
        ->count();
    

        $totalUsersCount = User::count();
        $users=User::All();
        $rooms=Room::whereIn('id',$roomID)->get();
        $items=Item::All();
        $dateToCount = Carbon::today(); // You can replace this with your desired date

        // Get the count of users who have made reservations on the specified date
        $usersWithReservationsCount = Reservation::whereDate('created_at', $dateToCount)->distinct('user_id')->count();
        $usersWithReservationsCount = max($usersWithReservationsCount, 0);

        $totalRoomsCount = count($subadminRoomIDs); // Count the room IDs in the array
        $pendingCounts = [];
        $itemsCount=Item::count();
        $departmentsCount=Department::count();
        foreach ($subadminRoomIDs as $roomID) {
            $pendingCount = $reservations->filter(function ($reservation) use ($roomID) {
                return $reservation->room_id == $roomID;
            })->count();

            $pendingCounts[$roomID] = $pendingCount;
        }
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

        $currentDate = now()->format('Y-m-d'); // Get the current date in 'Y-m-d' format
        $dailyReservations = []; // Initialize an empty array
        $roomColors = [
            'Kifaru' => 'Orange',
            'Shark Tank Boardroom' => 'Blue',
            'Executive Boardroom' => 'Green',
            'Oracle Lab' => 'Black',
            'Safaricom Lab' => 'Black',
            'Ericsson Lab' => 'Black',
            'Small Meeting Room' => 'Purple',
            'Samsung Lab' => 'Black'
            // Add more rooms and colors as needed
        ];
        
        foreach ($rooms as $room) {
            // Query to get daily reservation counts for a specific room on the current date
            $dailyCount = DB::table('reservations')
                ->where('room_id', $room->id)
                ->whereDate('created_at', $currentDate)
                ->count();
        
            // Get the background color for the room
            $backgroundColor = $roomColors[$room->name];
        
            // Format the data for the room
            $roomData = [
                'label' => $room->name,
                'data' => [$dailyCount], // Use an array with the count for the current date
                'backgroundColor' => $backgroundColor, // Use the color from $roomColors
                'borderColor' => 'rgba(255, 255, 255, 0.8)',
                'borderWidth' => 1,
            ];
        
            $dailyReservations[] = $roomData;
        }
        

        foreach ($acceptedReservations as $reservation) {
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

        return view('sub-admin.dashboard', compact('events', 'reservations', 'pendingCount', 'totalRoomsCount', 'usersWithReservationsCount', 'totalUsersCount', 'roomColors','users','rooms','items','acceptedReservations','dailyReservations','reservationsAcceptedCount','itemsCount','departmentsCount','pendingReservationsCount'));
    }
    public function reservation()
    {
        $subAdminRoomID = 1;
        $subAdminReservations = Reservation::where('room_id', $subAdminRoomID)->paginate(10);
        $pendingReservations = Reservation::where('room_id', $subAdminRoomID)->where('status', 'Pending')->paginate(10);
        $acceptedReservations = Reservation::where('room_id', $subAdminRoomID)->where('status', 'Accepted')->paginate(10);
        $declinedReservations = Reservation::where('room_id', $subAdminRoomID)->where('status', 'declined')->paginate(10);

        return view('sub-admin.reservation', compact('acceptedReservations', 'pendingReservations', 'declinedReservations'), ['subAdminReservations' => $subAdminReservations]);
    }
    public function updateReservationStatus(Request $request, $id)
    {
        // Get the user's role
        $userRole = Auth::user()->role;

        $validatedData = $request->validate([
            'status' => 'required|in:Pending,Accepted,Declined', // Include "Pending" as a valid status
            'remarks' => 'nullable|string|max:255',
        ]);

        $reservation = Reservation::findOrFail($id);

        // Set the admin's ID and name based on the status and role
        if ($userRole == 1 || $userRole == 2) {
            $adminName = Auth::user()->name; // Superadmin or Admin
        } else {
            $adminName = 'Unknown Admin';
        }

        // Set the status and remarks
        $reservation->status = $validatedData['status'];
        $reservation->remarks = $validatedData['remarks'];

        if ($reservation->status === 'Accepted') {
            // Capture and store the admin's ID who accepted the reservation
            $reservation->accepted_by_user_id = Auth::user()->id; // Superadmin's ID or Admin's ID

            // Notify the user that the booking has been accepted
            $reservation->user->notify(new BookingAcceptedNotification($reservation, $adminName));
        } elseif ($reservation->status === 'Declined') {
            // Capture and store the admin's ID who declined the reservation
            $reservation->declined_by_user_id = Auth::user()->id; // Superadmin's ID or Admin's ID

            // Notify the user that the booking has been declined and include a remark
            $reservation->user->notify(new BookingDeclinedNotification($reservation, $request->remarks, $adminName));
        }

        $reservation->save();

        Activity::create([
            'user_id' => Auth::user()->id,
            'action' => 'Reservation Status Updated',
            'description' => "Reservation  status updated to {$validatedData['status']} by $adminName for user: {$reservation->user->name}",
        ]);
        // Pass the $adminName variable to the view along with other necessary data
        return redirect()->back()->with('success', 'Reservation status updated successfully!');
    }
    public function showProfile()
    {
        return view('sub-admin.profile');
    }
    public function searchReservations(Request $request)
    {
        $searchQuery = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $subAdminRoomID = 1;

        $query =Reservation::where('room_id', $subAdminRoomID);
    
        if (!empty($status)) {
            $query->where('status', $status);
        }
    
        if (!empty($searchQuery)) {
            $query->where(function ($subquery) use ($searchQuery) {
                $subquery->whereHas('user', function ($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');
                })
                ->orWhereHas('room', function ($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');
                })
                ->orWhere('event', 'like', '%' . $searchQuery . '%');
            });
        }
    
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('ReservationDate', [$startDate, $endDate]);
        }
    
        $Results = $query->paginate(10);
    
        return view('sub-admin.search-results', compact('Results'));
    }
    public function createReservation(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'requestItems' => 'boolean',
            'itemRequests' => 'nullable|array', // Make the itemRequests field optional            
            'itemRequests.*' => 'exists:items,id', // Validate each item in the array           
            'duration' => 'required|integer',
            'reservationDate' => 'required|date',
            'reservationTime' => 'required',
            'timelimit' => 'required',
            'selectRoom' => 'required|exists:rooms,id',
            'event' => 'nullable|string',
        ]);

        $startTime = strtotime($validatedData['reservationTime']);
        $endTime = date('H:i', strtotime("+" . $validatedData['duration'] . " hours", $startTime));

        // Check if the room is available at the selected date and time
        $isRoomAvailable = !DB::table('reservations')
            ->where('room_id', $validatedData['selectRoom'])
            ->where('reservationDate', $validatedData['reservationDate'])
            ->where('reservationTime', $validatedData['reservationTime'])
            ->exists();

        if (!$isRoomAvailable) {
            throw ValidationException::withMessages(['selectRoom' => 'This room is not available at the selected date and time.']);
        }
        

        // Create a new reservation instance and populate it with the form data
        $reservation = new Reservation();
        $reservation->user_id = $validatedData['user_id'];
        $reservation->reservationDate = $validatedData['reservationDate'];
        $reservation->reservationTime = $validatedData['reservationTime'];
        $reservation->timelimit = $endTime; // Store the calculated end time
        $reservation->room_id = $validatedData['selectRoom'];
        $reservation->event = $validatedData['event'];

        $reservation->status = 'accepted';

        // Save the reservation to the database
        $reservation->save();

        if ($request->has('itemRequests')) {
            $itemRequests = $request->input('itemRequests');
            // Now, you can work with $itemRequests
        }
        
    

        // Attach selected items (if any) to the reservation
        Session::flash('success', 'Reservation made successfully!');

        // Redirect back with a success message
        return redirect()->back();
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
            return redirect()->back()->with('error', 'Incorrect current password');
        }

        // Check if the new password is too obvious (e.g., contains "password" or "123456")
        $obviousPasswords = ['password', '123456']; // Add more obvious passwords if needed
        if (in_array($request->new_password, $obviousPasswords)) {
            return redirect()->back()->with('error', 'Please choose a stronger password');
        }

        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully');
    }
}
