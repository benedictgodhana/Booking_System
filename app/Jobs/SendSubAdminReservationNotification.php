<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Notifications\SubAdminReservationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSubAdminReservationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $room;
    protected $reservation;

    public function __construct(Room $room, Reservation $reservation)
    {
        $this->room = $room;
        $this->reservation = $reservation;
    }

    public function handle()
    {
        // Fetch SubAdmin users based on your criteria (e.g., role or attribute)
        $subAdmins = User::where('role', 2)->get();

        // Send notifications to each SubAdmin user
        foreach ($subAdmins as $subAdmin) {
            $subAdmin->notify(new SubAdminReservationNotification($this->room, $this->reservation));
        }
    }
}
