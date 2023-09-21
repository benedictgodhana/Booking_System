<?php

namespace App\Notifications;

use App\Mail\AdmReservationCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;
use App\Models\Room;

class AdminReservationNotification extends Notification
{
    protected $reservation;
    protected $adminName;

    public function __construct($reservation, $adminName)
    {
        $this->reservation = $reservation;
        $this->adminName = $adminName;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Hello ' . $this->adminName . ',')
            ->line('A new reservation has been created:')
            ->line('Room Name: ' . $this->reservation->room->name)
            ->line('Reservation Date: ' . $this->reservation->reservationDate)
            ->line('Reservation Time: ' . $this->reservation->reservationTime)
            ->action('View Reservation', url('/admin/reservations')) // Adjust the URL as needed
            ->line('Thank you for using our reservation system.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
