<!DOCTYPE html>
<html>

<head>
    <title>New Reservation Request</title>
</head>

<body>
    <p>Hello iLab Support Team,</p>
    <p>{{ $userName }} has made a reservation and requested IT services, setup assistance, or items. Here are the reservation details:</p>

    <ul>
        <li><strong>Name:</strong> {{ $userName }}</li>
        <li><strong>Selected Room:</strong> {{ $selectedRoom }}</li>
        <li><strong>Date of Reservation:</strong> {{ $reservationDate }}</li>
        <li><strong>Reservation Time:</strong> {{ $reservationTime }}</li>
        <li><strong>End of Reservation:</strong> {{ $duration }}</li>
        <li><strong>Event:</strong> {{ $event }}</li>
        <li><strong>IT Services Requested:</strong> {{ $itServicesRequested ? 'Yes' : 'No' }}</li>
        <li><strong>Setup Assistance Requested:</strong> {{ $setupAssistanceRequested ? 'Yes' : 'No' }}</li>
        
        <li><strong>Item Requests:</strong>
            @if (!empty($itemRequests))
            <ul>
                @foreach ($itemRequests as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
            @else
            None
            @endif
        </li>
    </ul>
    <p>For any inquiries, please contact us at <a href="ilabsupport@strathmore.edu">ilabsupport@strathmore.edu</a></p>

    <!-- You can include more reservation details here -->

</body>

</html>