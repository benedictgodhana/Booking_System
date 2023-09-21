<!DOCTYPE html>
<html>

<head>
    <title>User Logged In Notification</title>
</head>

<body>
    <div>
        <h1>Hello, {{ $notifiable}}!</h1>
        <p>You have successfully logged in to our application.</p>
    </div>


    <p>
        To visit Dashboard, click the button below:
        <a href="{{ $VisitDashboard }}" target="_blank">{{Visit Dashboard}}</a>
    </p>


    <p>Thank you for using our application!</p>


    <p>© 2023 Strathmore. All rights reserved.</p>

</body>

</html>