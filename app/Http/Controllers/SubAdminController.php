<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\BookingAcceptedNotification;
use App\Notifications\BookingDeclinedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SubAdminController extends Controller
{
    //
    public function dashboard()
    {
        $events = [];
        $reservations = Reservation::where('status', 'accepted')->get();

        // Filter reservations for accepted rooms only
        $subadminRoomIDs = [1, 2, 3, 4, 5, 6, 7, 8]; // Replace with the IDs of rooms accepted by the admin
        $acceptedReservations = $reservations->filter(function ($reservation) use ($subadminRoomIDs) {
            return in_array($reservation->room_id, $subadminRoomIDs);
        });
        $totalUsersCount = User::count();

        $dateToCount = Carbon::today(); // You can replace this with your desired date

        // Get the count of users who have made reservations on the specified date
        $usersWithReservationsCount = Reservation::whereDate('created_at', $dateToCount)->distinct('user_id')->count();
        $usersWithReservationsCount = max($usersWithReservationsCount, 0);

        $totalRoomsCount = count($subadminRoomIDs); // Count the room IDs in the array
        $pendingCounts = [];

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

        return view('sub-admin.dashboard', compact('events', 'reservations', 'pendingCount', 'totalRoomsCount', 'usersWithReservationsCount', 'totalUsersCount', 'roomColors'));
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
}
