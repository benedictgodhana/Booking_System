<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CafeteriaReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $selectedOptions;

    /**
     * Create a new message instance.
     *
     * @param  array  $selectedOptions
     * @return void
     */
    public function __construct(array $selectedOptions)
    {
        $this->selectedOptions = $selectedOptions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cafeteria Reservation Request')
            ->view('emails.cafeteria_reservation')
            ->with([
                'selectedOptions' => $this->selectedOptions,
            ]);
    }
}
