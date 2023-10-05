<!DOCTYPE html>
<html>

<head>
    <!-- Your email header content -->
</head>

<body>
    <!-- Email content -->
    <p>Hello {{ $userName }},</p>
    <p>Your reservation request has been submitted for the following room:</p>
    <p>Room Name: {{ $roomName }}</p>
    <p>Event:{{$Event}}</p>
    <p>Reservation Date: {{ $reservationDate }}</p>
    <p>Reservation Time: {{ $reservationTime }}</p>
    <p>End of Reservation:{{$EndReservation}}</p>
    <!-- Other email content -->

    <!-- Call to Action Button -->
    <p>
        To view your reservation, click the button below:
        <a href="{{ $viewReservationUrl }}" target="_blank">{{ $viewReservationUrl }}</a>
    </p>

    <!-- Thank You Message -->
    <p>Thank you for using our reservation system.</p>

    <!-- Contact Information -->
    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

    <!-- Email Footer -->
    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>