<!DOCTYPE html>
<html>

<head>
    <title>Cafeteria Reservation Request</title>
</head>

<body>
    <p>Hello Cafeteria,</p>

    <p>A guest has made a cafeteria reservation with the following options:</p>

    <ul>
        @foreach($selectedOptions as $option)
        <li>{{ $option }}</li>
        @endforeach
    </ul>

    <p>Please review and confirm the reservation.</p>

    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>


    <p>Thank you!</p>
</body>

</html>