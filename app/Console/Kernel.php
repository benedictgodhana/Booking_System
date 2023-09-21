<?php

namespace App\Console;

use App\Mail\FeedbackEmail;
use App\Models\Reservation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Find reservations that have ended and where feedback has not been sent
            $endedReservations = Reservation::where('timelimit', '<', now())
                ->whereNull('feedback_sent')
                ->get();

            // ...

            foreach ($endedReservations as $reservation) {
                // Ensure that the user relationship exists and is not null
                if ($reservation->user) {
                    // Send feedback email
                    Mail::to($reservation->user->email)->send(new FeedbackEmail($reservation));

                    // Update the reservation to mark feedback as sent
                    $reservation->update(['feedback_sent' => now()]);
                }
            }

            // ...

        })->everyMinute(); // This will run the task every minute.
        // Adjust the time to match when reservations typically end.
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
