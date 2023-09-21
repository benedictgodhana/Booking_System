<!DOCTYPE html>
<html>

<head>
    <title>Reservation Request</title>
</head>

<body>
    <p>Dear {{ $data['guest_name'] }},</p>
    <p>Your reservation for Room <strong>{{ $data['room_name'] }}</strong> has been received successfully.</p>
    <p>Reservation Details:</p>
    <ul>
        <li><strong>Reservation Date:</strong> {{ $data['reservation_date'] }}</li>
        <li><strong>Reservation Time:</strong> {{ $data['reservation_time'] }}</li>
        <li><strong>End of Reservation:</strong> {{ $data['timelimit'] }}</li>
        <li><strong>Your Department:</strong> {{$data['department']}}</li>
        <li><strong>Event:</strong> {{$data['event']}}</li>
        

        <!-- Add more reservation details here -->
    </ul>
    <p>Thank you for using our reservation system.</p>
    <p>For any inquiries, please contact us at <a href="mailto:booking@ilab.com">booking@ilab.com</a></p>

    <!-- Email Footer -->


    <p>Best regards,<br>iLab Room Booking System</p>

    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>