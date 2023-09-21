<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuestSuperadminNotificationMail extends Mailable
{
public $data; // Make $data public so it can be accessed in the view.
public $superadminName;

use Queueable, SerializesModels;

/**
* Create a new message instance.
*
* @param array $data
* @param string $superadminName
* @return void
*/
public function __construct(array $data, string $superadminName)
{
$this->data = $data;
$this->superadminName = $superadminName; // Set the Superadmin's name.
}

/**
* Build the message.
*
* @return $this
*/
public function build()
{
return $this->view('guest.superadmin_notification') // Use your email blade template
->subject('New Guest Reservation Notification')
->from('booking@ilab.com', 'iLab Booking System'); // Set the "from" address
}
}