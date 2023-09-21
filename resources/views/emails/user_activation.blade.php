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

    <p>You can now log in and start using the iLab Room Booking System.</p>
    <p>To start using the system, Kindly follwo the link below to reset your password</p>
    <a href="{{ route('password.request') }}">Reset Password</a>

    <p>If you have any questions or need further assistance, please don't hesitate to contact our support team.</p>

    <p>Thank you for choosing iLab Room Booking System.</p>

    <p>© 2023 Strathmore. All rights reserved.</p>
</body>

</html>