<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuestAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $adminName;
    public $reservations;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $content
     */
    public function __construct($reservations, $adminName)
    {
        $this->reservations = $reservations;
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
            ->subject('New Guest Reservation Notification')
            ->view('guest.admin_notification')
            ->with([
                'reservations' => $this->reservations,
                'adminName' => $this->adminName,
            ]);
    }
}
