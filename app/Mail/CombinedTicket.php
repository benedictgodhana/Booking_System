<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CombinedTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketContent;

    /**
     * Create a new message instance.
     *
     * @param  string  $ticketContent
     * @return void
     */
    public function __construct($ticketContent)
    {
        $this->ticketContent = $ticketContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Combined Reservation and Item Request Ticket')
            ->view('guest.combined-ticket')
            ->from('booking@ilab.com', 'iLab Booking System');
    }
}
