<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
        $this->user = $reservation->user; // Get the user associated with the reservation
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Room Reservation Confirmation')
        ->view('emails.reservation-confirmation');
    }
}
