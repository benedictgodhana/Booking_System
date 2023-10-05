<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation Notification</title>
</head>

<body>
    <p>Hello {{ $userName }},</p>

    <p>Your account has been successfully activated.</p>

    <p>You can now log in to the iLab Room Booking System using the following credentials:</p>

    <ul>
        <li><strong>Email:</strong> {{ $userEmail }}</li>
        <li><strong>Password:</strong> Kenya@2030</li>
    </ul>

    <p>Click on the following link to log in:</p>
    <a href="{{route('LoginPage')}}">Log In</a>

    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

    <p>Thank you for choosing iLab Room Booking System.</p>

    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>
