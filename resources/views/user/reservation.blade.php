@extends('layout/layout')

@section('space-work')

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Reservation Date</th>
                <th>Event</th>
                <th>Items Borrowed (Optional)</th>
                <th>Room Assign</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->reservationDate }}</td>
                <td>{{ $reservation->event }}</td>
                <td>{{ $reservation->item->name}}</td>
                <td>{{ $reservation->room->name }}</td>
                <td>{{ $reservation->status }}</td>
                <td>{{ $reservation->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
@endsection