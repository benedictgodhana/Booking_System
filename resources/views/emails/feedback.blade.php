<!DOCTYPE html>
<html>

<head>
    <title>Feedback for Your Reservation</title>
</head>

<body>
    <p>Dear {{ $reservation->user->name }},</p>

    <p>We hope you had a great experience in the <strong>{{ $reservation->room->name }}</strong> room with your recent reservation. Your feedback is important to us, and we would appreciate it if you could take a moment to share your thoughts and suggestions.</p>

    <p><a href="http://127.0.0.1:8000/feedback/create">Provide Feedback</a></p>

    <p>Your valuable input will help us enhance your experience and serve you better in the future.</p>

    <p>Thank you for choosing our services!</p>

    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

    <!-- Email Footer -->
    <p>© 2023 Strathmore. All rights reserved.</p>

</body>

</html>