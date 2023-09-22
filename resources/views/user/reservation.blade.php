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
                <th>Room Requested</th>
                <th>Reservation Date</th>
                <th>Reservation Time</th>
                <th>End of Reservation</th>
                <th>Event</th>
                <td>Item Requested(optional)</td>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                 <td>{{ $reservation->room->name }}</td>
                <td>{{ $reservation->reservationDate }}</td>
                <td>{{ Carbon\Carbon::parse($reservation->reservationTime)->format('h:i A') }}</td>
                <td>{{ Carbon\Carbon::parse($reservation->timelimit)->format('h:i A') }}</td>
                <td>{{ $reservation->event }}</td>
                <td>{{ $reservation->item->name ?? 'N/A' }}</td>
                <td>{{ $reservation->status }}</td>
                <td>{{ $reservation->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $reservations ->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $reservations ->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            @for ($i = 1; $i <= $reservations ->lastPage(); $i++)
                <li class="page-item {{ $i == $reservations ->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $reservations ->url($i) }}">{{ $i }}</a>
                </li>
                @endfor

                <li class="page-item {{ $reservations->currentPage() == $reservations->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $reservations ->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
        </ul>
    </nav>
</body>
@endsection