<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubReservationCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $reservation;
    public $subAdminName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation, $subAdminName)
    {
        $this->reservation = $reservation;
        $this->subAdminName = $subAdminName;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subreservation_created')
        ->subject('New Reservation Created')
        ->from('booking@ilab.com', 'iLab Booking System');

    }
}
