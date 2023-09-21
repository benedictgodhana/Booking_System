<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdmReservationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $adminName;

    /**
     * Create a new message instance.
     *
     * @param  Reservation  $reservation
     * @param  string  $adminName
     * @return void
     */
    public function __construct($reservation, $adminName)
    {
        $this->reservation = $reservation;
        $this->adminName = $adminName;
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
            ->view('emails.admreservation_created')
            ->with([
                'reservations' => $this->reservation,
                'adminName' => $this->adminName,
            ]);
    }
}
