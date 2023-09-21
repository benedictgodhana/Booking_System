<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation; // Replace with your reservation model
use App\Mail\FeedbackEmail; // Replace with your feedback email Mailable
use Illuminate\Support\Facades\Mail;

class SendFeedbackEmails extends Command
{
    protected $signature = 'send:feedback-emails';
    protected $description = 'Send feedback emails for reservations that have ended';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get reservations that have ended
        $endedReservations = Reservation::where('timelimit', '<', now())->get();
        
        foreach ($endedReservations as $reservation) {
            // Send feedback email          
            Mail::to($reservation->user->email)->send(new FeedbackEmail($reservation));

            // Update the reservation to mark feedback as sent
            $reservation->update(['feedback_sent' => now()]);
        }

        $this->info('Feedback emails sent successfully.');
    }
}
