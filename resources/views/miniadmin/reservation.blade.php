@php
use Carbon\Carbon;
@endphp
@extends('layout/layout')

@section('space-work')

<head>
    <style>
        /* Your styles here */
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

        .actions {
            display: flex;
        }

        .action-button {
            margin-right: 5px;
        }
    </style>
</head>

<h2>Reservation Data</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Items (Optional)</th>
        <th>Event</th>
        <th>Reservation Date</th>
        <th>Reservation Time</th>
        <th>End Time</th> <!-- Add this column -->
        <th>Rooms</th>
        <th>Status</th>
        <th>Remarks</th>
        <th>Action</th>
    </tr>
    @foreach($MinAdminReservations as $reservation)
    <tr>
        <td>{{ $reservation->user->name }}</td>
        <td>{{ $reservation->item->name}}</td>
        <td>{{ $reservation->event}}</td>
        <td>{{ $reservation->reservationDate }}</td>
        <td>{{ $reservation->reservationTime }}</td>
        <td>{{ $reservation->timelimit }}</td>
        <td>{{ $reservation->room->name }}</td>
        <td>{{ $reservation->status }}</td>
        <td>{{ $reservation->remarks }}</td>

        <td class="actions">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal{{ $reservation->id }}">
                Update Status
            </button>
            <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal" data-target="#viewModal{{ $reservation->id }}">
                View Details
            </button>
        </td>

        </td>
    </tr>

    <!-- Modal -->
    <div class="modal fade" id="updateModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{ $reservation->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{ $reservation->id }}">Update Reservation Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('miniadmin.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Status field -->
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" name="status" id="status" style="border: 1px solid;">
                                <option value="Accepted">Accepted</option>
                                <option value="Declined">Declined</option>
                            </select>
                        </div>

                        <!-- Remarks field (optional) -->
                        <div class="form-group">
                            <label for="remarks">Remarks:</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="4" style="border: 1px solid;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="showAlert('Success', 'Reservation status updated successfully!', 'success')">Update</button>
                        @include('sweet::alert')
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Add more rows as needed -->
</table><br>
@foreach($MinAdminReservations as $reservation)
<!-- Modal for Viewing Reservation Details -->
<div class="modal fade" id="viewModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $reservation->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel{{ $reservation->id }}">View Reservation Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
                <p><strong>Items (Optional):</strong> {{ $reservation->item->name}}</p>
                <p><strong>Event:</strong> {{ $reservation->event }}</p>
                <p><strong>Reservation Date:</strong> {{ $reservation->reservationDate }}</p>
                <p><strong>Reservation Time:</strong> {{ $reservation->reservationTime }}</p>
                <p><strong>End Time:</strong> {{ $reservation->timelimit }}</p>
                <p><strong>Rooms:</strong> {{ $reservation->room->name }}</p>
                <p><strong>Status:</strong> {{ $reservation->status }}</p>
                <p><strong>Remarks:</strong> {{ $reservation->remarks }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<script>
    function showAlert(title, message, icon) {
        Swal.fire({
            title: title,
            text: message,
            icon: icon,
            timer: 5000, // Adjust the time you want the alert to be visible (in milliseconds)

        });
    }
</script>

@endsection