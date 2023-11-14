<!DOCTYPE html>
<html>

<head>
    <!-- Your email header content -->
</head>

<body>
    <!-- Email content -->
    <p><strong>Hello {{ $userName }} , </strong></p>
    <p><strong>Your reservation request has been submitted for the following room: </strong></p>
    <p><strong>Room Name: </strong> {{ $roomName }}</p>
    <p><strong>Event: </strong>{{$Event}}</p>
    <p><strong>Reservation Date: </strong> {{ $reservationDate }}</p>
    <p><strong>Reservation Time: {{ $reservationTime }}</p>
    <p><strong>End of Reservation: </strong>{{$EndReservation}}</p>
    <p><strong>Comments:</strong>{{$Comments}}</p>
    <p><strong>IT Assistance Details:</strong>{{$Details}}</p>
    <p><strong>Meal SetUp Details:</strong>{{$MealDetails}}</p>


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

    <p>To access the system, please use this link: <strong><a href="https://shaba.strathmore.edu/">https://shaba.strathmore.edu/</a></strong></p>

    <!-- Email Footer -->
    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>