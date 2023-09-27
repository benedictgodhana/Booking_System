<!DOCTYPE html>
<html>

<head>
    <!-- Your email header content -->
</head>

<body>
    <!-- Email content -->
    <p>Hello {{ $miniadminName }},</p>

    @foreach ($reservations as $reservation)
    <p>A new reservation has been created by {{ $reservation->user ? $reservation->user->name : 'Unknown User' }} and requires your approval:</p>
    <p>Room Name: {{ $reservation->room->name }}</p>
    <p>Reservation Date: {{ $reservation->reservationDate }}</p>

    <!-- Format Reservation Time as "h:i A" (AM/PM) -->
    <p>Reservation Time: {{ Carbon\Carbon::parse($reservation->reservationTime)->format('h:i A') }}</p>

    <!-- Format timelimit as "h:i A" (AM/PM) -->
    <p>Timelimit: {{ Carbon\Carbon::parse($reservation->timelimit)->format('h:i A') }}</p>

    <p>Event: {{ $reservation->event }}</p>

    <!-- Call to Action Button -->
    <p>
        To approve this reservation, please log in to the admin panel.
        <!-- Add a link to your admin panel -->
    </p>

    <!-- Thank You Message -->
    <p>Thank you for using our reservation system.</p>

    <!-- Contact Information -->
    <p>For any inquiries, please contact us at <a href="ilabroombooking@strathmore.edu">ilabroombooking@strathmore.edu</a></p>

    <!-- Email Footer -->
    <p>© 2023 Strathmore. All rights reserved.</p>

    <hr>
    @endforeach

</body>

</html>