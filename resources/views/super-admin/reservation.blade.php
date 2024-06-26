   @extends('layout/layout')

   @section('space-work')
   @php
   use Carbon\Carbon;
   @endphp
   <style>
    .user-table {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px; /* Increased padding for better spacing */
        margin-bottom: 20px;
        overflow-x: auto; /* Add horizontal scroll for small screens */
    }

    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 12px; /* Increased padding for better spacing */
        border: 1px solid #ccc;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f5f5f5; /* Slightly different background color */
    }

    tr:hover {
        background-color: #e0e0e0; /* Hover effect for rows */
    }

    /* Style the buttons */
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color:#0056b3;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
    }

    .btn-success:hover {
        background-color: #1d943c;
    }
</style>

   <!-- Table for pending reservations -->



   <div class="user-table">
       <div>
           <button id="showPendingButton" class="btn btn-primary">
               <i class="fas fa-clock"></i> Show Pending Reservations
           </button>
           <button id="showAcceptedButton" class="btn btn-success">
               <i class="fas fa-check-circle"></i> Show Accepted Reservations
           </button>
       </div><br>
       <!-- Add this code within your Blade view -->
<form method="GET" action="{{ route('superadmin.searchReservations') }}">
    <div class="form-row">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search...">
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



       <div id="pendingReservations" style="display: block;">
           <h2>Pending Reservations</h2>
           <table>
               <tr>
                   <th>Name</th>
                   <th>Department</th>
                   <th>Contact</th>
                   <th>Items (Optional)</th>
                   <th>Event</th>
                   <th>Reservation Date</th>
                   <th>End Reservation Date</th>
                   <th>Reservation Time</th>
                   <th>End Time</th> <!-- Add this column -->
                   <th>Rooms</th>
                   <th>Status</th>
                   <th>Remarks</th>
                   <th>Made on</th>
                   <th>Action</th>
                   <!-- Add other headers as needed -->
               </tr>
               @foreach($pendingReservations as $reservation)
               <tr>
                   <td>
                       @if ($reservation->user)
                       {{ $reservation->user->name }}
                       @else
                       {{ $reservation->guest_name }}
                       @endif
                   </td>
                   <td style="word-wrap: break-word; max-width: 150px;" >@if ($reservation->user)
                       {{ $reservation->user->department }}
                       @else
                       {{ $reservation->guest_department }}
                       @endif
                   </td>
                   <td>{{$reservation->user->contact}}</td>
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
                   <td>{{ $reservation->event }}</td>
                   <td>{{ $reservation->reservationDate }}</td>
                   <td>{{ $reservation->booking_end_date }}</td>
                   <td>{{ Carbon::parse($reservation->reservationTime)->format('h:i A') }}</td>
                   <td>{{ Carbon::parse($reservation->timelimit)->format('h:i A') }}</td>
                   <td>{{ $reservation->room->name }}</td>
                   <td>{{ $reservation->status }}</td>
                   <td>{{ $reservation->remarks }}</td>
                   <td>{{ $reservation->created_at }}</td>


                   <td class="actions">

                       <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal" data-target="#viewModal{{ $reservation->id }}">
                           <i class="fas fa-eye"></i> View Details
                       </button>
                   </td>
               </tr>
               @endforeach

           </table><br>
           <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $pendingReservations->currentPage() == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pendingReservations->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                @for ($i = 1; $i <= $pendingReservations->lastPage(); $i++)
                    <li class="page-item {{ $i == $pendingReservations->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $pendingReservations->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <li class="page-item {{ $pendingReservations->currentPage() == $pendingReservations->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $pendingReservations->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

       </div>

       <!-- Table for accepted reservations -->
       <div id="acceptedReservations" style="display: none;">
           <h2>Accepted Reservations</h2>
           <table>
               <tr>
                   <th>Name</th>
                   <th>Department</th>
                   <th>Contact</th>
                   <th>Items (Optional)</th>
                   <th>Event</th>
                   <th>Reservation Date</th>
                   <th>Reservation Time</th>
                   <th>End Time</th> <!-- Add this column -->
                   <th>Rooms</th>
                   <th>Status</th>
                   <th>Remarks</th>
                   <th>Accepted on</th>
                   <th>Action</th>
                   <!-- Add other headers as needed -->
               </tr>
               @foreach($acceptedReservations as $reservation)
               <tr>
                   <td>
                       @if ($reservation->user)
                       {{ $reservation->user->name }}
                       @else
                       {{ $reservation->guest_name }}
                       @endif
                   </td>
                   <td style="word-wrap: break-word; max-width: 150px;">@if ($reservation->user)
                       {{ $reservation->user->department }}
                       @else
                       {{ $reservation->guest_department }}
                       @endif
                   </td>
                   <td>{{$reservation->user->contact}}</td>
                   <td>{{ $reservation->item->name ?? 'N/A' }}</td>
                   <td>{{ $reservation->event }}</td>
                   <td>{{ $reservation->reservationDate }}</td>
                   <td>{{ Carbon::parse($reservation->reservationTime)->format('h:i A') }}</td>
                   <td>{{ Carbon::parse($reservation->timelimit)->format('h:i A') }}</td>
                   <td>{{ $reservation->room->name }}</td>
                   <td>{{ $reservation->status }}</td>
                   <td>{{ $reservation->remarks }}</td>
                   <td>{{ $reservation->updated_at }}</td>

                   <td class="actions">

                       <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal" data-target="#viewModal{{ $reservation->id }}">
                           <i class="fas fa-eye"></i> View
                       </button>
                       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal{{ $reservation->id }}">
            Update
        </button>
                   </td>
               </tr>
               @endforeach
           </table><br>
           <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $acceptedReservations->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $acceptedReservations->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            @for ($i = 1; $i <= $acceptedReservations->lastPage(); $i++)
                <li class="page-item {{ $i == $acceptedReservations->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $acceptedReservations->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item {{ $acceptedReservations->currentPage() == $acceptedReservations->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $acceptedReservations->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

       </div>

       @foreach($pendingReservations as $reservation)
       <!-- Modal for Viewing Reservation Details -->

       <div class="modal fade" id="viewModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $reservation->id }}" aria-hidden="true">
           <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                   <div class="modal-header bg-primary">
                       <h5 style="margin-left:250px" class="modal-title" id="viewModalLabel{{ $reservation->id }}">View Reservation Details</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6">
                               <!-- Name -->
                               <div class="form-group">
                                   <label><i class="fas fa-user"></i> Name:</label>
                                   <p>
                                       @if ($reservation->user)
                                       {{ $reservation->user->name }}
                                       @else
                                       {{ $reservation->guest_name }}
                                       @endif
                                   </p>
                               </div>
                               <hr>

                               <!-- Department -->
                               <div class="form-group">
                                   <label><i class="fas fa-building"></i> Department:</label>
                                   <p>
                                       @if ($reservation->user)
                                       {{ $reservation->user->department }}
                                       @else
                                       {{ $reservation->guest_department }}
                                       @endif
                                   </p>
                               </div>
                               <hr>
                               <div class="form-group">
                                   <label><i class="fas fa-phone"></i>Contact:</label>
                                   <p>{{ $reservation->user->contact }}</p>
                               </div>
                               <hr>

                               <!-- Event -->
                               <div class="form-group">
                                   <label><i class="fas fa-calendar"></i> Event:</label>
                                   <p>{{ $reservation->event }}</p>
                               </div>
                               <hr>

                           </div>
                           <div class="col-md-6">
                               <!-- Items (Optional) -->
                               <div class="form-group">
                                   <label><i class="fas fa-box"></i> Items (Optional):</label>
                                   <p>{{ $reservation->item->name ?? 'N/A' }}</p>
                               </div>
                               <hr>

                               <!-- Reservation Date -->
                               <div class="form-group">
                                   <label><i class="fas fa-calendar-alt"></i> Reservation Date:</label>
                                   <p>{{ $reservation->reservationDate }}</p>
                               </div>
                               <hr>

                               <!-- Reservation Time -->
                               <div class="form-group">
                                   <label><i class="fas fa-clock"></i> Reservation Time:</label>
                                   <p>{{ Carbon::parse($reservation->reservationTime)->format('h:i A') }}</p>
                               </div>
                               <hr>

                               <div class="form-group">
                                   <label><i class="fas fa-clock"></i>End of Reservation:</label>
                                   <p>{{ Carbon::parse($reservation->timelimit)->format('h:i A') }}</p>
                               </div>
                               <hr>
                               <div class="form-group">
                                   <label><i class="fas fa-check-circle"></i> Status:</label>
                                   <p>{{ $reservation->status }}</p>
                               </div>
                               <hr>
                           </div>
                       </div>
                       <!-- Additional fields go here -->
                   </div>
                   <div class="modal-footer">
                   @php
                        $currentDate = \Carbon\Carbon::now();
                        $currentDateTime = \Carbon\Carbon::now();
                        $reservationDate = \Carbon\Carbon::parse($reservation->reservationDate);
                        $timeLimit = \Carbon\Carbon::parse($reservation->timelimit);

                        // Compare the current date with the reservation date
                        $isDatePassed = $currentDate->gt($reservationDate);
                        $isTimeLimitPassed = $currentDateTime->gt($timeLimit);
                    @endphp

                    @if ($isDatePassed)
                        <!-- Display an alert if the reservation date has passed -->
                        <button type="button" class="btn btn-warning" onclick="showAlert('Alert', 'The reservation date has passed.', 'warning')">
                            <i class="fas fa-exclamation-triangle"></i> Reservation Date Passed
                        </button>
                    @else
                        <!-- Show the update button if the reservation date is in the future -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal{{ $reservation->id }}">
                            <i class="fas fa-edit"></i> Update Status
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   </div>
               </div>
           </div>
       </div>
       @endforeach

       @foreach($acceptedReservations as $reservation)
       <div class="modal fade" id="updateModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{ $reservation->id }}" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="updateModalLabel{{ $reservation->id }}">Update Reservation Status</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <form action="{{ route('superadmin.updateReservationStatus', $reservation->id) }}" method="POST">
                       @csrf
                       @method('PATCH')
                       <div class="modal-body">
                           <!-- Status field -->
                           <div class="form-group row">
                               <label for="status" class="col-sm-3 col-form-label">
                                   <i class="fas fa-info-circle"></i> Status:
                               </label>
                               <div class="col-sm-9">
                                   <select class="form-control" name="status" id="status">
                                       <option value="Cancelled">Cancel</option>
                                   </select>
                               </div>
                           </div>

                           <!-- Remarks field (optional) -->
                           <div class="form-group row">
                               <label for="remarks" class="col-sm-3 col-form-label">
                                   <i class="fas fa-comment"></i> Remarks:
                               </label>
                               <div class="col-sm-9">
                                   <textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
                               </div>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary" onclick="showAlert('Success', 'Reservation status updated successfully!', 'success')">
                               <i class="fas fa-check"></i> Update
                           </button>
                           @include('sweet::alert')
                       </div>
                   </form>
               </div>
           </div>
       </div>
       @endforeach

       @foreach($pendingReservations as $reservation)
       <div class="modal fade" id="updateModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel{{ $reservation->id }}" aria-hidden="true">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header bg-primary">
                       <h5 style="margin-left:150px" class="modal-title" id="updateModalLabel{{ $reservation->id }}">Update Reservation Status</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <form action="{{ route('superadmin.updateReservationStatus', $reservation->id) }}" method="POST">
                       @csrf
                       @method('PATCH')
                       <div class="modal-body">
                           <!-- Status field -->
                           <div class="form-group row">
                               <label for="status" class="col-sm-3 col-form-label">
                                   <i class="fas fa-info-circle"></i> Status:
                               </label>
                               <div class="col-sm-9">
                                   <select class="form-control" name="status" id="status">
                                       <option value="Accepted">Accepted</option>
                                       <option value="Declined">Declined</option>
                                   </select>
                               </div>
                           </div>

                           <!-- Remarks field (optional) -->
                           <div class="form-group row">
                               <label for="remarks" class="col-sm-3 col-form-label">
                                   <i class="fas fa-comment"></i> Remarks:
                               </label>
                               <div class="col-sm-9">
                                   <textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
                               </div>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary" onclick="showAlert('Success', 'Reservation status updated successfully!', 'success')">
                               <i class="fas fa-check"></i> Update
                           </button>
                           @include('sweet::alert')
                       </div>
                   </form>
               </div>
           </div>
       </div>
       @endforeach

       @foreach($acceptedReservations as $reservation)
       <!-- Modal for Viewing Reservation Details -->
       <div class="modal fade" id="viewModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $reservation->id }}" aria-hidden="true">
           <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                   <div class="modal-header bg-primary">
                       <h5 style="margin-left:250px" class="modal-title" id="viewModalLabel{{ $reservation->id }}">View Reservation Details</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6">
                               <!-- Name -->
                               <div class="form-group">
                                   <label><i class="fas fa-user"></i> Name:</label>
                                   <p>
                                       @if ($reservation->user)
                                       {{ $reservation->user->name }}
                                       @else
                                       {{ $reservation->guest_name }}
                                       @endif
                                   </p>
                               </div>
                               <hr>

                               <!-- Department -->
                               <div class="form-group">
                                   <label><i class="fas fa-building"></i> Department:</label>
                                   <p>
                                       @if ($reservation->user)
                                       {{ $reservation->user->department }}
                                       @else
                                       {{ $reservation->guest_department }}
                                       @endif
                                   </p>
                               </div>
                               <hr>

                               <!-- Event -->
                               <div class="form-group">
                                   <label><i class="fas fa-calendar"></i> Event:</label>
                                   <p>{{ $reservation->event }}</p>
                               </div>
                               <hr>
                           </div>
                           <div class="col-md-6">
                               <!-- Items (Optional) -->
                               <div class="form-group">
                                   <label><i class="fas fa-box"></i> Items (Optional):</label>
                                   <p>{{ $reservation->item->name ?? 'N/A' }}</p>
                               </div>
                               <hr>

                               <!-- Reservation Date -->
                               <div class="form-group">
                                   <label><i class="fas fa-calendar-alt"></i> Reservation Date:</label>
                                   <p>{{ $reservation->reservationDate }}</p>
                               </div>
                               <hr>

                               <!-- Reservation Time -->
                               <div class="form-group">
                                   <label><i class="fas fa-clock"></i> Reservation Time:</label>
                                   <p>{{ $reservation->reservationTime }}</p>
                               </div>
                               <hr>


                               <div class="form-group">
                                   <label><i class="fas fa-clock"></i>End of Reservation:</label>
                                   <p>{{ Carbon::parse($reservation->timelimit)->format('h:i A') }}</p>
                               </div>
                               <hr>
                               <div><label><i class="fas fa-check-circle"></i> Status:</label>
                                   <p>{{ $reservation->status }}</p>
                               </div>


                           </div>
                       </div>
                       <!-- Additional fields go here -->
                   </div>
                   <div class="modal-footer">

                       <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times"></i> Close
                       </button>
                   </div>
               </div>
           </div>
       </div>
       @endforeach




       <script>
           document.addEventListener("DOMContentLoaded", function() {
               const showPendingButton = document.getElementById('showPendingButton');
               const showAcceptedButton = document.getElementById('showAcceptedButton');
               const pendingReservations = document.getElementById('pendingReservations');
               const acceptedReservations = document.getElementById('acceptedReservations');

               showPendingButton.addEventListener('click', function() {
                   pendingReservations.style.display = 'block';
                   acceptedReservations.style.display = 'none';
               });

               showAcceptedButton.addEventListener('click', function() {
                   pendingReservations.style.display = 'none';
                   acceptedReservations.style.display = 'block';
               });
           });
       </script>

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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const showPendingButton = document.getElementById('showPendingButton');
        const showAcceptedButton = document.getElementById('showAcceptedButton');
        const pendingReservations = document.getElementById('pendingReservations');
        const acceptedReservations = document.getElementById('acceptedReservations');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const filterButton = document.getElementById('filterButton');
        const reservationsTable = document.getElementById('reservationsTable'); // Change the ID to match your table

        showPendingButton.addEventListener('click', function() {
            pendingReservations.style.display = 'block';
            acceptedReservations.style.display = 'none';
        });

        showAcceptedButton.addEventListener('click', function() {
            pendingReservations.style.display = 'none';
            acceptedReservations.style.display = 'block';
        });

        filterButton.addEventListener('click', function() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            // Use AJAX to fetch filtered reservations
            $.ajax({
                url: '{{ route('filter.pendingReservations') }}', // Define your backend route for pending reservations
                type: 'POST', // You can use POST or GET depending on your backend route
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    const reservations = response.reservations;

                    // Clear the current table
                    reservationsTable.innerHTML = '';

                    // Add headers to the table
                    reservationsTable.innerHTML = `
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <!-- Add other headers as needed -->
                        </tr>
                    `;

                    // Populate the table with filtered reservations
                    reservations.forEach(function(reservation) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${reservation.name}</td>
                            <td>${reservation.department}</td>
                            <!-- Add other columns as needed -->
                        `;
                        reservationsTable.appendChild(row);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>


       @endsection
