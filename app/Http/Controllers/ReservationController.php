<?php

namespace App\Http\Controllers;

use App\Rules\RoomAvailability;

use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Arr;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array|max:5',
            'reservationDate' => 'required|date',
            'reservationTime' => 'required',
            'selectRoom' => 'required',
            'timeLimit' => 'required', 'event' => 'nullable|string', // Add this line for the "event" field
            // Add the custom validation rule
            'selectRoom' => [
                'required',
                new RoomAvailability(
                    $request->input('selectRoom'),
                    $request->input('reservationDate'),
                    $request->input('reservationTime')
                ),
            ],
        ]);

        $isRoomAvailable = Reservation::where('room_id', $request->input('selectRoom'))
            ->where('reservationDate', $request->input('reservationDate'))
            ->where('reservationTime', $request->input('reservationTime'))
            ->doesntExist();

        if (!$isRoomAvailable) {
            return response()->json(['error' => 'This room is not available at the selected date and time.'], 422);
        }


        // Get the first 5 selected items and join them into a comma-separated string
        $selectedItems = array_slice($validatedData['items'], 0, 5);
        $itemIds = implode(',', $selectedItems);

        $reservation = new Reservation();
        $reservation->user_id = auth()->user()->id;
        $reservation->reservationTime = $validatedData['reservationTime'];
        $reservation->reservationDate = Carbon::parse($validatedData['reservationDate']);
        $reservation->room_id = $validatedData['selectRoom'];
        $reservation->timelimit = $validatedData['timeLimit'];
        $reservation->item_id = $itemIds;
        $reservation->event = $validatedData['event']; // Set the "event" field




        // Set the default status to "Pending"
        $reservation->status = 'Pending';

        $reservation->save();

        $items = Item::all();
        $rooms = Room::all();

        Alert::success('Success', 'Reservation created successfully');
        return view('user.booking', compact('items', 'rooms'));
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

        // Save the changes to the database
        $reservation->save();

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
}
