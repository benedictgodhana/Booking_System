<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MiniAdminController extends Controller
{
    public function dashboard()
    {
        // Add your logic to fetch data and display the dashboard view
        return view('miniadmin.dashboard');
    }
    public function reservation()
    {
        $miniAdminRoomID =[4, 5, 6, 7, 8];
        $MiniAdminReservations = Reservation::whereIn('room_id', $miniAdminRoomID)->get();

        return view('miniadmin.reservation', ['MinAdminReservations' => $MiniAdminReservations]);
    }
    public function updateReservationStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:Accepted,Declined',
            'remarks' => 'nullable|string|max:255',
        ]);

        $reservation = Reservation::findOrFail($id);

        $reservation->status = $validatedData['status'];
        $reservation->remarks = $validatedData['remarks'];

        $reservation->save();

        // Display a success message using SweetAlert
        Alert::success('Success', 'Reservation status updated successfully!')->autoClose(60000);
        return redirect()->back();
    }


}
