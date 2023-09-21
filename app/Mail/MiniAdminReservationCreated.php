<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MiniAdminReservationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $miniadminName;

    /**
     * Create a new message instance.
     *
     * @param  Reservation  $reservation
     * @param  string  $adminName
     * @return void
     */
    public function __construct($reservation, $miniadminName)
    {
        $this->reservation = $reservation;
        $this->miniadminName = $miniadminName;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New Reservations Created')
            ->from('booking@ilab.com', 'iLab Booking System')
            ->view('emails.miniadmin_reservation')
            ->with([
                'reservations' => $this->reservation,
                'miniadminName' => $this->miniadminName,
            ]);
    }
}
