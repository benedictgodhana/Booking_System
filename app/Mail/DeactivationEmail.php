<?php

namespace App\Mail;

use App\Models\User; // Import the User model if needed
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeactivationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account Deactivation Notification')
            ->from('booking@ilab.com', 'iLab Booking System')
            ->view('emails.deactivation')
            ->with([
                'userName' => $this->user->name,
                // You can pass more data to the email template if needed
            ]);
    }
}
