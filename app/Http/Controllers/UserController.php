<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function dashboard()
    {
        return view('user.dashboard');
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
        $reservations = $user->reservations; // Assuming you have defined a relationship in the User model       
        return view('user.reservation', compact('reservations'));
    }
    public function getAcceptedRooms()
    {
        $acceptedRooms = Room::where('status', 'accepted')->get();

        return $acceptedRooms;
    }   
   
}
