<?php

namespace App\Http\Controllers;

use App\Mail\GuestBookingAcceptedNotification;
use App\Mail\MiniAdminReservationCreated;
use App\Models\Activity;
use App\Models\Department;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\BookingAcceptedNotification;
use App\Notifications\BookingDeclinedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class MiniAdminController extends Controller
{
    public function dashboard()
    {
        $events = [];
        $reservations = Reservation::where('status', 'accepted')->get();
        $roomID=[4,5,6,7,8];
        // Filter reservations for accepted rooms only
        $miniadminRoomIDs = [1, 2, 3, 4, 5, 6, 7, 8]; // Replace with the IDs of rooms accepted by the admin
        $acceptedReservations = $reservations->filter(function ($reservation) use ($miniadminRoomIDs) {
            return in_array($reservation->room_id, $miniadminRoomIDs);
        });
        $itemsCount=Item::count();
        $departmentsCount=Department::count();
        $totalUsersCount = User::count();
        $pendingReservations = Reservation::whereIn('room_id', $roomID)
        ->where('status', 'pending')
        ->get();
        $reservationsAcceptedCount = Reservation::whereIn('room_id', $roomID)
        ->where('status', 'Accepted')
        ->count();        
        $pendingReservationsCount = Reservation::whereIn('room_id', $roomID)
        ->where('status', 'Pending')
        ->count();
        $users=User::all();
        $rooms=Room::whereIn('id',$roomID)->get();
        $items=Item::all();
        $pendingBookingsCount = $pendingReservations->count();
        $roomsCount = Room::count();
        $usersCount = User::where('role', 0)->count();
        $reservationsAcceptedCount =Reservation::whereIn('room_id',$roomID)
        ->where('status', 'Accepted')
        ->count();

        
        $dateToCount = Carbon::today(); // You can replace this with your desired date

        // Get the count of users who have made reservations on the specified date
        $usersWithReservationsCount = Reservation::whereDate('created_at', $dateToCount)->distinct('user_id')->count();
        $usersWithReservationsCount = max($usersWithReservationsCount, 0);

        $totalRoomsCount = count($miniadminRoomIDs); // Count the room IDs in the array
        
        $pendingCounts = [];
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
        



        foreach ($miniadminRoomIDs as $roomID) {
            $pendingCount = $reservations->filter(function ($reservation) use ($roomID) {
                return $reservation->room_id == $roomID;
            })->count();

            $pendingCounts[$roomID] = $pendingCount;
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

        return view('miniadmin.dashboard', compact('events', 'reservations', 'pendingCount', 'totalRoomsCount', 'usersWithReservationsCount', 'totalUsersCount', 'roomColors','pendingReservations','pendingBookingsCount','roomsCount','usersCount','reservationsAcceptedCount','users','rooms','items','pendingReservationsCount','itemsCount','departmentsCount','dailyReservations'));
    }


    public function reservation()
    {
        $miniadminRoomIDs = [4, 5, 6, 7, 8]; // Array containing room IDs you want to fetch       
        $miniadminName = User::where('role', 4)->first()->name;


        $pendingReservations = Reservation::whereIn('room_id', $miniadminRoomIDs)->where('status', 'Pending')
            ->orderBy('created_at', 'asc') // Order by the created_at column in ascending order
            ->paginate(10);
        $acceptedReservations = Reservation::whereIn('room_id', $miniadminRoomIDs)->where('status', 'Accepted')
            ->orderBy('created_at', 'asc') // Order by the created_at column in ascending order
            ->paginate(10);
        $reservations = Reservation::paginate(10);
        return view('miniadmin.reservation', compact('acceptedReservations', 'pendingReservations'));
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
        if ($userRole == 1 || $userRole == 4) {
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

        if ($request->status === 'Accepted'
        ) {
            // Notify the user that the booking has been accepted
            $reservation->user->notify(new BookingAcceptedNotification($reservation));
        } elseif ($request->status === 'Declined') {
            // Notify the user that the booking has been declined and include a remark
            $reservation->user->notify(new BookingDeclinedNotification($reservation, $request->remark));
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
        return view('miniadmin.profile');
    }
    public function updatePassword(Request $request)
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

    public function searchReservations(Request $request)
    {
        $searchQuery = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $miniadminRoomIDs = [4, 5, 6, 7, 8];
        $query =Reservation::where('room_id', $miniadminRoomIDs);
    
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
    
        return view('miniadmin.search-results', compact('Results'));
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
            'capacity' => 'required|integer',
            'reservationDate' => 'required|date',
            'reservationTime' => 'required|date_format:H:i',
            'timelimit' => 'required|date_format:H:i',
            'selectRoom' => 'required|exists:rooms,id',
            'event' => 'nullable|string',

        ]);

       
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
        $reservation->timelimit = $validatedData['timelimit']; // Store the calculated end time
        $reservation->room_id = $validatedData['selectRoom'];
        $reservation->event = $validatedData['event'];

        $reservation->status = 'Accepted';

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
}
