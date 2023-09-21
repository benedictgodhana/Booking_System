<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AdminReservationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminReservationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;
    protected $room;
    protected $reservation;

    public function __construct($admin,$room, $reservation)
    {
        $this->admin = $admin;
        $this->room = $room;
        $this->reservation = $reservation;
    }

    public function handle()
    {
        $Admins = User::where('role', 2)->get();

        // Send notifications to each SubAdmin user
        foreach ($Admins as $Admin) {
        $Admin->notify(new AdminReservationNotification($this->room, $this->reservation));           
    }
}
}