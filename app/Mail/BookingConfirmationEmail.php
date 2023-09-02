<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Booking Confirmation')
        ->view('emails.booking-confirmation')
        ->with([
            'userName' => $this->userName, // Pass user's name
            // Add other data you want to include in the email
        ]);
    }
}
