<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBookings()
    {
        // Retrieve booking data from your database
        $bookings = Reservation::select('title', 'start', 'end')->get();

        return response()->json($bookings);
    }

 

}
