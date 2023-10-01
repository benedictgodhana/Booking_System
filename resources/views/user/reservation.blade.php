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
                        <td>{{ $reservation->item->name ?? 'N/A' }}</td>
                        <td>{{ $reservation->status }}</td>
                        <td>{{ $reservation->remarks }}</td>
                        <td>
                        @if ($reservation->status === 'Declined')
                            <!-- Button indicating reservation is declined -->
                            <button style="border-radius:10px" type="button" class="btn btn-info" disabled>
                                <i class="fas fa-ban"></i> Reservation Declined
                            </button>
                        @elseif ($reservation->status === 'Canceled')
                            <!-- Button indicating reservation is canceled -->
                            <button style="border-radius:10px" type="button" class="btn btn-secondary" disabled>
                                <i class="fas fa-ban"></i> Reservation Canceled
                            </button>
                        @else
                            <!-- Button to open the cancellation modal -->
                            <button style="width:200px;border-radius:10px" type="button" class="btn btn-danger"
                                data-toggle="modal" data-target="#cancelModal{{ $reservation->id }}">
                                <i class="fas fa-times"></i> Cancel Reservation
                            </button>
                        @endif
                    </td>

                    </tr>
                    @endforeach
                </tbody>
            </table><br>
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

            <!-- Modal for Canceling Reservation -->
            @foreach($reservations as $reservation)
            <div class="modal fade" id="cancelModal{{ $reservation->id }}" tabindex="-1" role="dialog"
                aria-labelledby="cancelModalLabel{{ $reservation->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
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
                                <button type="submit" class="btn btn-danger">Confirm Cancelation</button>
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
