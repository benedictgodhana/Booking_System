<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class BookingAcceptedNotification extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
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
            ->view('emails.booking_accepted', [
                'roomName' => $this->reservation->room->name,
                'reservationDate' => $this->reservation->reservationDate,
                'reservationTime' => $this->reservation->reservationTime,
                'viewReservationUrl' => url('/reservations'),
            ])
            ->subject('Room Booking System - Booking Accepted')
            ->from('booking@ilab.com', 'iLab Booking System')
            ->line('Your booking request has been accepted.')
            ->line('Room: ' . $this->reservation->room->name)
            ->line('Reservation Date: ' . $this->reservation->reservationDate)
            ->line('Reservation Time: ' . $this->reservation->reservationTime)
            ->action('View Reservation', url('/reservations'))
            ->line('Thank you for using our reservation system.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
