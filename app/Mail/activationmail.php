<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class activationmail extends Mailable
{
    public $user;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
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
        return $this->subject('Account Activation Notification')
        ->from('booking@ilab.com', 'iLab Booking System')
        ->view('emails.user_activation')
        ->with([
            'userName' => $this->user->name,
            'userEmail'=>$this->user->email,
            // You can pass more data to the email template if needed
        ]);
    }
}
