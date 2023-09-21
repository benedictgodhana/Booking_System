<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create(Request $request)
    {
        $reservationId = $request->input('id'); // Get the reservation ID from the form

        $reservation = Reservation::find($reservationId);

        // Pass the reservation data to the view
        return view('feedback.create', compact('reservation'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'feedback_text' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5', // Adjust rating validation as needed
            'reservation_id' => 'required|exists:reservations,id', // Validate that the reservation_id exists in the reservations table
        ]);

        $user = Auth::user(); // Assuming you have user authentication
        $reservationId = $request->input('reservation_id'); // Get the reservation ID from the form
        $rating = $request->input('rating');

        $feedback = new Feedback();
        $feedback->user_id = $user->id;
        $feedback->reservation_id = $reservationId;
        $feedback->feedback_text = $validatedData['feedback_text'];
        $feedback->rating = $rating;

        $feedback->save();

        // Redirect back or to a thank-you page after submitting feedback
        return redirect()->route('feedback.create')->with('success', 'Thank you for your feedback!');
    }
}
