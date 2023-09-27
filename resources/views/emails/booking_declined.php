<!DOCTYPE html>
<html>

<head>
    <!-- Your email header content -->
</head>

<body>
    <!-- Email content -->
    <p>Your booking request has been accepted.</p>
    <p>Room: {{ $Room }}</p>
    <p>Reservation Date: {{ $ReservationDate }}</p>
    <p>Reservation Time: {{ $ReservationTime }}</p>
    <!-- Other email content -->

    <!-- Call to Action Button -->
    <p>
        To view your reservation, click the button below:
        <a href="{{ $viewReservationUrl }}" target="_blank">{{ $viewReservationUrl }}</a>
    </p>

    <!-- Thank You Message -->
    <p>Thank you for using our reservation system.</p>

    <p>For any inquiries, please contact us at <a href="ilabroombooking@strathmore.edu">ilabroombooking@strathmore.edu</a></p>


    <!-- Email Footer -->
    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>