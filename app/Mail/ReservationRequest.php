<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $selectedRoom;
    public $reservationDate;
    public $reservationTime;
    public $duration;
    public $event;
    public $itServicesRequested;
    public $setupAssistanceRequested;
    public $itemRequests;

    public function __construct(
        $userName,
        $selectedRoom,
        $reservationDate,
        $reservationTime,
        $duration,
        $event,
        $itServicesRequested,
        $setupAssistanceRequested,
        $itemRequests
    ) {
        $this->userName = $userName;
        $this->selectedRoom = $selectedRoom;
        $this->reservationDate = $reservationDate;
        $this->reservationTime = $reservationTime;
        $this->duration = $duration;
        $this->event = $event;
        $this->itServicesRequested = $itServicesRequested;
        $this->setupAssistanceRequested = $setupAssistanceRequested;
        $this->itemRequests = $itemRequests;
    }

    public function build()
    {
        return $this->subject('New Reservation Request')
            ->view('emails.reservation_request')
            ->from('booking@ilab.com', 'iLab Booking System');
    }
}
