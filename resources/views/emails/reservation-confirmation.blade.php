<!DOCTYPE html>
<html>

<head>
    <title>Reservation Confirmation</title>
</head>

<body>
    <p>Dear {{ $user->name }},</p>

    <p>Your room reservation details:</p>

    <ul>
        <li>Room: {{ $reservation->room->name }}</li>
        <li>Date: {{ $reservation->reservationDate }}</li>
        <!-- Add more reservation details as needed -->
    </ul>

    <p>Thank you for using our reservation system.</p>
</body>

</html>