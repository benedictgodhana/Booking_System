<?php

namespace App\Jobs;

use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\MiniAdminReservationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMiniAdminReservationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $miniAdmin;
    protected $room;
    protected $reservation;

    public function __construct(User $miniAdmin, Room $room, Reservation $reservation)
    {
        $this->miniAdmin = $miniAdmin;
        $this->room = $room;
        $this->reservation = $reservation;
    }

    public function handle()
    {
        // Send an email notification to the miniadmin
        $miniAdminEmail = $this->miniAdmin->email;

        Mail::send('emails.miniadmin_reservation', [
            'room' => $this->room,
            'reservation' => $this->reservation,
        ], function ($message) use ($miniAdminEmail) {
            $message->to($miniAdminEmail)->subject('New Reservation Notification');
        });
    }}
