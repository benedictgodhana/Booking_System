<!DOCTYPE html>
<html>

<head>
    <!-- Your email header content -->
</head>

<body>
    <!-- Email content -->
    <p>Hello {{ $superAdminName }},</p>
    <p>A new reservation has been created by {{ $reservation->user->name }} and requires your approval:</p>
    <p>Room Name: {{ $reservation->room->name }}</p>
    <p>Reservation Date: {{ $reservation->reservationDate }}</p>
    <p>Reservation Time: {{ Carbon\Carbon::parse($reservation->reservationTime)->format('h:i A') }}</p>
    <p>End of Reservation: {{ Carbon\Carbon::parse($reservation->timelimit)->format('h:i A') }}</p>

    <p>Event: {{ $reservation->event }}</p>

    <p>Meal SetUp Details: <strong>{{ $reservation->meal_setup_details }}</strong></p>


    <!-- Other email content -->

    <!-- Call to Action Button -->
    <p>
        To approve this reservation, please log in to the admin panel.
        <!-- Add a link to your admin panel -->
    </p>

    <!-- Thank You Message -->
    <p>Thank you for using our reservation system.</p>

    <!-- Contact Information -->
    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

    <p>To access the system, please use this link: <strong><a href="https://shaba.strathmore.edu/">https://shaba.strathmore.edu/</a></strong></p>


    <!-- Email Footer -->
    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>