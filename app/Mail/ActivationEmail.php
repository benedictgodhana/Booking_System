<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $activationUrl;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  string  $activationUrl
     * @return void
     */
    public function __construct($user, $activationUrl)
    {
        $this->user = $user;
        $this->activationUrl = $activationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Activate Your Account')
            ->from('booking@ilab.com', 'iLab Booking System')
            ->view('emails.activation')
            ->with([
                'activationUrl' => $this->activationUrl, // Use the activation URL you passed to the constructor
            ]);
    }
}
