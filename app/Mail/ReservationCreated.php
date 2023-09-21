<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $reservation;
    public $superAdminName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation, $superAdminName)
    {
        $this->reservation = $reservation;
        $this->superAdminName = $superAdminName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservation_created')
            ->subject('New Reservation Created')
            ->from('booking@ilab.com', 'iLab Booking System');
    }
}
