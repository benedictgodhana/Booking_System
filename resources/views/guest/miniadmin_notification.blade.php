<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Guest Reservation Notification</title>
</head>

<body>
    <h1>New Guest Reservation Notification</h1>
    <p>Hello {{ $miniadminName }},</p>
    <p>A new guest reservation request has been made. Here are the details:</p>

    <ul>
        @foreach ($reservations as $reservation)

        <li><strong>Guest Name:</strong> {{ $reservation->user->name}}</li>
        <li><strong>Room Name:</strong> {{ $reservation->room->name}}</li>
        <li><strong>Reservation Date:</strong> {{ $reservation->reservationDate }}</li>
        <li><strong>Reservation Time:</strong> {{ Carbon\Carbon::parse($reservation->reservationTime)->format('h:i A') }}</li>
        <li><strong>End of Reservation:</strong> {{ Carbon\Carbon::parse($reservation->timelimit)->format('h:i A') }}</li>
        <li><strong>Guest's Department:</strong> {{$reservation->guest_department}}</li>
        <li><strong>Guest's Contact:</strong>{{$reservation->user->contact}}</li>
        <li><strong>Event:</strong> {{$reservation->event}}</li>
        <li><strong>Comments</strong><span style="color:blue"> {{$reservation->comment}}</span></li>

        <!-- Add more reservation details as needed -->
    </ul>
    <p>
        To approve this reservation, please log in to the admin panel.
        <!-- Add a link to your admin panel -->
    </p>

    <p>Thank you for using our reservation system.</p>
    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

    <!-- Email Footer -->


    <p>Best regards,<br>iLab Room Booking System</p>

    <p>© 2023 Strathmore. All rights reserved.</p>
    @endforeach

</body>

</html>