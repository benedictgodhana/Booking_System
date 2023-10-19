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

        .card {
            border: none;
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
<div style="margin: 4px, 4px; padding: 4px; width: auto; height: 86vh; overflow-x: hidden; overflow-y: scroll;">

    <div class="card">
        <div class="card-body">
            <h2 style="margin-left:10px;font-size:23px" class="card-title">Reservation List</h2><br><br>
            <form method="GET" action="{{ route('user.searchReservations') }}">
    <div class="form-row">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by event or remarks">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-control">
                <option value="">Filter by Status</option>
                <option value="Pending">Pending</option>
                <option value="Accepted">Accepted</option>
                <option value="Declined">Declined</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control" placeholder="Start Date">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control" placeholder="End Date">
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>
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
                        <th>Action</th>
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
                        <td>
                        @if ($reservation->items->count() > 0)
                    <ul>
                        @foreach ($reservation->items as $item)
                            <li>{{ $item->name }}</li>
                        @endforeach
                    </ul>
                        @else
                            N/A
                        @endif
                        </td>
                        <td>{{ $reservation->status }}</td>
                        <td>{{ $reservation->remarks }}</td>
                        <td class="actions">
        @php
            $currentDate = \Carbon\Carbon::now();
            $currentDateTime = \Carbon\Carbon::now();
            $reservationDate = \Carbon\Carbon::parse($reservation->reservationDate);
            $timeLimit = \Carbon\Carbon::parse($reservation->timelimit);
            // Compare the current date with the reservation date
            $isDatePassed = $currentDate->gt($reservationDate);
            $isTimeLimitPassed = $currentDateTime->gt($timeLimit);
        @endphp

        @if ($reservation->status === 'Canceled')
            <!-- Reservation is already cancelled, disable the button -->
            <button style="width:200px;border-radius:10px" type="button" class="btn btn-warning" disabled>
                <i class="fas fa-times"></i> Cancelled
            </button>
        @elseif ($isDatePassed || $isTimeLimitPassed)
            <!-- Reservation date has passed, disable cancellation -->
            <button style="width:200px;border-radius:10px" type="button" class="btn btn-danger" disabled>
                <i class="fas fa-lock"></i> Locked Reservation
            </button>
        @else
            <!-- Reservation date is in the future, enable cancellation -->
            <button style="width:200px;border-radius:10px" type="button" class="btn btn-success"
                data-toggle="modal" data-target="#cancelModal{{ $reservation->id }}">
                <i class="fas fa-times"></i> Cancel Reservation
            </button>
        @endif
    </td>

                    </tr>
                    @endforeach
                </tbody>
            </table><br>
            <!-- Pagination with collapsed version when more than 20 pages -->
<nav aria-label="Page navigation" style="width: 100px; margin-left: 680px">
    <ul class="pagination justify-content-center">
        <!-- Display the first page link -->
        <li class="page-item {{ $reservations->currentPage() == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $reservations->appends(request()->input())->url(1) }}">1</a>
        </li>

        <!-- Display an ellipsis if there are more than 20 pages -->
        @if ($reservations->lastPage() > 20)
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>
        @endif

        <!-- Display page numbers within a range -->
        @php
            $start = max(2, $reservations->currentPage() - 2);
            $end = min($reservations->lastPage() - 1, $reservations->currentPage() + 2);
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $i == $reservations->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $reservations->appends(request()->input())->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- Display an ellipsis if there are more than 20 pages -->
        @if ($reservations->lastPage() > 20)
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>
        @endif

        <!-- Display the last page link -->
        <li class="page-item {{ $reservations->currentPage() == $reservations->lastPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $reservations->appends(request()->input())->url($reservations->lastPage()) }}">{{ $reservations->lastPage() }}</a>
        </li>
    </ul>
</nav>


            <!-- Modal for Canceling Reservation -->
            @foreach($reservations as $reservation)
            <div class="modal fade" id="cancelModal{{ $reservation->id }}" tabindex="-1" role="dialog"
                aria-labelledby="cancelModalLabel{{ $reservation->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="cancelModalLabel{{ $reservation->id }}">Cancel Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to cancel this reservation for <span>{{$reservation->room->name}}?</span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <form action="{{ route('cancelReservation', $reservation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-success">Confirm Cancelation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
@endsection
