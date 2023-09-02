<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class SubAdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('sub-admin.dashboard');
    }
    public function reservation()
    {
        $subAdminRoomID = 1;
        $subAdminReservations = Reservation::where('room_id', $subAdminRoomID)->get();

        return view('sub-admin.reservation', ['subAdminReservations' => $subAdminReservations]);
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
