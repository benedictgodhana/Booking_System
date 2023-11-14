<!DOCTYPE html>
<html>

<head>
    <title>Reservation Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        #container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            margin: 0;
            color: #777;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div id="container">
        <h1>Reservation Request</h1>
        <p>Dear {{ $data['guest_name'] }},</p>
        <p>Your reservation for Room <strong>{{ $data['room_name'] }}</strong> has been received successfully.</p>
        <p>Reservation Details:</p>
        <ul>
            <li><strong>Reservation Date:</strong> {{ $data['reservation_date'] }}</li>
            <li><strong>Reservation Time:</strong> {{ $data['reservation_time'] }}</li>
            <li><strong>End of Reservation:</strong> {{ $data['timelimit'] }}</li>
            <li><strong>Your Department:</strong> {{$data['department']}}</li>
            <li><strong>Contact Number:</strong>{{$data['Contact']}}</li>
            <li><strong>Event:</strong> {{$data['event']}}</li>
            <li><strong>Comments</strong>: <span>{{$data['Comments']}}</span></li>
            <li><strong>IT Assistance Details</strong>: <span>{{$data['additionalDetails']}}</span></li>
            <li><strong>Meal SetUp Details</strong>: <span>{{$data['MealDetails']}}</span></li>

        </ul>
        <p>Thank you for using our reservation system.</p>
        <p>For any inquiries, please contact us at <a href="mailto:ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

        <p>To access the system, please use this link: <strong><a href="https://shaba.strathmore.edu/">https://shaba.strathmore.edu/</a></strong></p>


        <!-- Email Footer -->
        <p>Best regards,<br>iLab Room Booking System</p>
        <p>© 2023 Strathmore. All rights reserved.</p>
    </div>
</body>

</html>
