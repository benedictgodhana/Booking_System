<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class BookingDeclinedNotification extends Notification
{
    use Queueable;

    protected $reservation;
    protected $remark;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation, $remark)
    {
        $this->reservation = $reservation;
        $this->remark = $remark;
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
            ->subject('Booking Declined')
            ->from('booking@ilab.com', 'iLab Booking System')
            ->line('Your booking request has been declined.')
            ->line('Room: ' . $this->reservation->room->name)
            ->line('Reservation Date: ' . $this->reservation->reservationDate)
            ->line('Reservation Time: ' . $this->reservation->reservationTime)
            ->line('Admin Remark: ' . $this->remark)
            ->line('Thank you for using our reservation system.')
            ->line('© 2023 Strathmore. All rights reserved.');
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
