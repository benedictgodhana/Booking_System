<?php

namespace App\Console\Commands;

use App\Mail\FeedbackEmail;
use App\Models\Reservation;
use App\Notifications\FeedbackNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckReservationStatus extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:check';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and process ended reservations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Find reservations that have ended and where feedback has not been sent
        $endedReservations = Reservation::where('timelimit', '<', now())
            ->whereNull('feedback_sent')
            ->get();

        foreach ($endedReservations as $reservation) {
            // Send feedback email for each ended reservation
            Mail::to($reservation->user->email)->send(new FeedbackEmail($reservation));

            // Mark feedback as sent
            $reservation->update(['feedback_sent' => now()]);
        }

        $this->info('Reservations checked and feedback sent.');
    }
}
