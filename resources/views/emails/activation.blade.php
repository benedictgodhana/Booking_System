<!DOCTYPE html>
<html>

<head>
    <title>Account Activation</title>
</head>

<body>
    <p>Hello {{ $user->name }},</p>
    <p>Welcome to our iLab Room Booking System! To activate your account, please click the following link:</p>
    <a href="{{ $activationUrl }}">Activate Account</a>
    <p>If you did not request this, please ignore this email.</p>
</body>

</html>