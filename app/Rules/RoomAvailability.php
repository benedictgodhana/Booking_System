<?php

namespace App\Rules;

use App\Models\Reservation as ModelsReservation;
use Illuminate\Contracts\Validation\Rule;
use App\Reservation;

class RoomAvailability implements Rule
{
    protected $roomId;
    protected $reservationDate;
    protected $reservationTime;

    public function __construct($roomId, $reservationDate, $reservationTime)
    {
        $this->roomId = $roomId;
        $this->reservationDate = $reservationDate;
        $this->reservationTime = $reservationTime;
    }

    public function passes($attribute, $value)
    {
        // Check if there is a conflicting reservation for the same room, date, and time
        return !ModelsReservation::where('room_id', $this->roomId)
            ->where('reservationDate', $this->reservationDate)
            ->where('reservationTime', $this->reservationTime)
            ->exists();
    }

    public function message()
    {
        return 'This room is not available at the selected date and time.';
    }
}
