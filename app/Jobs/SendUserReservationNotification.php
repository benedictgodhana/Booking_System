<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Models\Room;
use App\Notifications\UserReservationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserReservationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $room;
    protected $reservation;
    protected $userName;

    public function __construct(Room $room, Reservation $reservation, $userName)
    {
        $this->room = $room;
        $this->reservation = $reservation;
        $this->userName = $userName;
    }

    public function handle()
    {
        // Send the notification
        $this->reservation->user->notify(
            new UserReservationNotification($this->room, $this->reservation, $this->userName)
        );
    }
}
