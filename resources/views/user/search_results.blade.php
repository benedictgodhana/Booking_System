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
            <h2 style="margin-left:10px;font-size:23px" class="card-title">Search Results</h2><br><br>
            <!-- Add a link to go back to the search form page if needed -->
            <a href="{{ route('reservation') }}" class="btn btn-primary">Back to Reservation List</a><br><br>
            
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

        @if ($reservation->status === 'Cancelled')
        <!-- Reservation is already canceled, disable the button -->
        <button style="width:200px;border-radius:10px" type="button" class="btn btn-warning" disabled>
            <i class="fas fa-times"></i> Cancelled
        </button>
        @elseif ($reservation->status === 'Declined')
        <!-- Reservation is declined, display a Declined message -->
        <button style="width:200px;border-radius:10px" type="button" class="btn btn-danger" disabled>
            Declined
        </button>
        @else
        <!-- Reservation date is in the future, enable cancellation and editing -->
        <button style="width:100px;border-radius:10px" type="button" class="btn btn-success"
            data-toggle="modal" data-target="#cancelModal{{ $reservation->id }}">
            <i class="fas fa-times"></i> Cancel
        </button>

        <button style="width:100px;border-radius:10px" type="button" class="btn btn-primary"
            data-toggle="modal" data-target="#editModal{{ $reservation->id }}">
            <i class="fas fa-pencil-alt"></i> Edit
        </button>
        @endif


                        </tr>
                        @endforeach
              
                </tbody>
            </table><br>

            <!-- Replace $Results with $reservations -->
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


            <!-- Pagination can remain the same as in the reservation.blade.php view -->
        </div>
    </div>

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
                    <button type="submit" class="btn btn-success">Confirm Cancellation</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@foreach($reservations as $reservation)
    <div class="modal fade" id="editModal{{ $reservation->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $reservation->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width:600px">
                <div class="modal-header  text-white" style="background:darkblue">
                    <h5 class="modal-title" id="editModalLabel{{ $reservation->id }}">Edit Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <!-- Add a form here to edit reservation details -->
                    <form action="{{ route('updateReservation', $reservation->id) }}" method="POST">                     
                        @csrf
                        @method('PUT')
                        <!-- Include fields to edit reservation information (e.g., date, time, event, etc.) -->
                        <!-- For example, to edit the event name: -->
                        <div class="form-group">
                            <label for="event">Room Requested</label>
                            <input type="text" class="form-control" id="event" name="event" value="{{ $reservation->room->name}}">
                        </div>

                                            <div class="form-group">
                            <label for="reservationDate">Reservation Date</label>
                            <input type="date" class="form-control" id="reservationDate" name="reservationDate" value="{{ $reservation->reservationDate }}">
                        </div>

                        <!-- To edit the reservation time: -->
                        <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="booking_date" class="form-label">Date of Reservation:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="date" id="booking_date" name="reservationDate" class="form-control" required value="{{ $reservation->reservationDate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="booking_time" class="form-label">Reservation Time:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input type="time" id="booking_time" name="reservationTime" class="form-control" required value="{{ $reservation->reservationTime }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="durationHours" class="form-label">Duration (in hours):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <select  id="hours" name="duration" class="form-select" required>
                                <option value="1">1 hour</option>
                                <option value="2">2 hours</option>
                                <option value="3">3 hours</option>
                                <option value="4">4 hours</option>
                                <option value="5">5 hours</option>
                                <option value="6">6 hours</option>
                                <option value="7">7 hours</option>
                                <option value="8">8 hours</option>
                                <option value="9">9 hours</option>
                                <option value="10">10 hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="durationMinutes" class="form-label">Duration (in minutes):</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <select id="minutes" name="duration" class="form-select" required>
                                <option value="5">5 minutes</option>
                                <option value="10">10 minutes</option>
                                <option value="15">15 minutes</option>
                                <option value="20">20 minutes</option>
                                <option value="25">25 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="35">35 minutes</option>
                                <option value="40">40 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="50">50 minutes</option>
                                <option value="55">55 minutes</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="event" class="form-label">Event Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                            </div>
                            <input type="text" id="event" name="event" class="form-control" placeholder="Enter Event Name" required value="{{ $reservation->event}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="timeLimit" class="form-label">End Reservation Time:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                            <input type="text" id="endTime" name="timeLimit" class="form-control" readonly value="{{ $reservation->timelimit}}">
                        </div>
                    </div>
                </div>

                 <div class="form-group">
                        <label for="remarks">Reason for rescheduling the reservation</label>
                        <textarea class="form-control" id="remarks" name="remarks">{{ $reservation->remarks }}</textarea>
                    </div>
                                            <!-- Include other fields as needed -->

                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
  // Get references to the elements
var hoursInput = document.getElementById('hours');
var minutesInput = document.getElementById('minutes');
var bookingTimeInput = document.getElementById('booking_time'); // Use "booking_time" to match the HTML ID
var endTimeInput = document.getElementById('endTime');

// Add event listeners to the duration and booking time inputs
hoursInput.addEventListener('input', calculateEndTime);
minutesInput.addEventListener('input', calculateEndTime);
bookingTimeInput.addEventListener('input', calculateEndTime);

// Function to calculate the end time
function calculateEndTime() {
    var selectedHours = parseInt(hoursInput.value);
    var selectedMinutes = parseInt(minutesInput.value);
    
    var bookingTime = bookingTimeInput.value.split(':');
    var bookingHours = parseInt(bookingTime[0]);
    var bookingMinutes = parseInt(bookingTime[1]);

    if (!isNaN(selectedHours) && !isNaN(selectedMinutes) && !isNaN(bookingHours) && !isNaN(bookingMinutes)) {
        // Calculate the end time based on booking time
        var endTime = new Date();
        endTime.setHours(bookingHours + selectedHours);
        endTime.setMinutes(bookingMinutes + selectedMinutes);
        
        // Format the end time as 'hh:mm AM/PM'
        var formattedEndTime = endTime.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Update the end time input field
        endTimeInput.value = formattedEndTime;
    } else {
        // Handle invalid input
        endTimeInput.value = 'Invalid input';
    }
}

// Initialize the end time calculation
calculateEndTime();

</script>

<script>
            document.addEventListener('DOMContentLoaded', function() {
                var bookingDateInput = document.getElementById('booking_date');

                // Get the current date in the format 'YYYY-MM-DD'
                var currentDate = new Date().toISOString().split('T')[0];

                // Set the minimum date of the booking_date input to the current date
                bookingDateInput.min = currentDate;
            });
        </script>

@endforeach

    </body>
    @endsection

