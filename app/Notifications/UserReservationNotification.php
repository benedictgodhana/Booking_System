<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;
use App\Models\Room;

class UserReservationNotification extends Notification
{
    use Queueable;

    protected $room;
    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Room $room, Reservation $reservation)
    {
        $this->room = $room;
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.reservation', [
                'userName' => $notifiable->name,
                'Event' => $this->reservation->event,
                'roomName' => $this->room->name,
                'reservationDate' => $this->reservation->reservationDate,
                'reservationTime' => $this->reservation->reservationTime,
                'Comments'=>$this->reservation->comment,
                'viewReservationUrl' => url('/user/reservations'),
            ])
            ->subject('Room Booking System - Reservation Confirmation')
            ->from('booking@ilab.com', 'iLab Booking System')
            ->line('Hello ' . $notifiable->name . ',')
            ->line('Your reservation request has been submitted for the following room:')
            ->line('Room Name: ' . $this->room->name)
            ->line('Reservation Date: ' . $this->reservation->reservationDate)
            ->line('Reservation Time: ' . $this->reservation->reservationTime)
            ->action('View Reservation', url('/user/reservations'))
            ->line('Thank you for using our reservation system.')
            ->line('For any inquiries, please contact us at booking@ilab.com')
            ->line('© 2023 Strathmore. All rights reserved.'); // Keep the footer here
    }
}
