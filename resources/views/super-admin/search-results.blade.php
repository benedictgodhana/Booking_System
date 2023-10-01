@extends('layout/layout')

@section('space-work')
@php
use Carbon\Carbon;
@endphp

<style>
    .user-management {
        background-color: #f5f5f5;
        padding: 0px;
    }

    .user-table {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    /* Your styles here */
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ccc;
        margin-top: 20px;
    }

    th,
    td {
        padding: 7px;
        border: 1px solid #ccc;
        text-align: left;
    }

    .pagination {
        margin-top: 20px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
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

    th,
    td {
        white-space: nowrap;
    }

    /* Optional: Add media query for smaller screens */
    @media (max-width: 768px) {
        table {
            font-size: 14px;
            /* Adjust font size for smaller screens */
        }
    }
</style>
<div style="margin: 4px, 4px; padding: 4px; width: auto; height: 86vh; overflow-x: hidden; overflow-y: scroll;">

@if(count($Results) > 0)
<div class="user-table">
    <h1>Search Results</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Items (Optional)</th>
                <th>Event</th>
                <th>Reservation Date</th>
                <th>Reservation Time</th>
                <th>End Time</th>
                <th>Rooms</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Made on</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Results as $reservation)
            <tr>
                <td>
                    @if ($reservation->user)
                    {{ $reservation->user->name }}
                    @else
                    {{ $reservation->guest_name }}
                    @endif
                </td>
                <td>@if ($reservation->user)
                    {{ $reservation->user->department }}
                    @else
                    {{ $reservation->guest_department }}
                    @endif
                </td>
                <td>{{ $reservation->item->name ?? 'N/A' }}</td>
                <td>{{ $reservation->event }}</td>
                <td>{{ $reservation->reservationDate }}</td>
                <td>{{ Carbon::parse($reservation->reservationTime)->format('h:i A') }}</td>
                <td>{{ Carbon::parse($reservation->timelimit)->format('h:i A') }}</td>
                <td>{{ $reservation->room->name }}</td>
                <td>{{ $reservation->status }}</td>
                <td>{{ $reservation->remarks }}</td>
                <td>{{ $reservation->created_at }}</td>

                <td class="actions">
                   @if ($reservation->status == 'Accepted')
                   <button style="width:140px;border-radius:10px" type="button" class="btn btn-success">
                    <i class="fas fa-check"></i> Accepted
                </button>
                    
                    <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#viewModal{{ $reservation->id }}">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    @endif
                    @if ($reservation->status == 'Pending')
                    <button style="border-radius:10px" type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#updateModal{{ $reservation->id }}">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                    
                    <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#viewModal{{ $reservation->id }}">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    @endif
                    @if ($reservation->status == 'Declined')
                    
                    <button style="width:140px;border-radius:10px" type="button" class="btn btn-info" disabled>
                    <i class="fas fa-ban"></i> Declined
                </button>
                    <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#viewModal{{ $reservation->id }}">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    @endif
                    @if ($reservation->status == 'Canceled')
                    
                    <button style="border-radius:10px" type="button" class="btn btn-success" disabled>
                    <i class="fas fa-ban"></i> Reservation Canceled
                </button>
                    <button style="margin-left:10px" type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#viewModal{{ $reservation->id }}">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item {{ $Results->currentPage() == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $Results->appends(request()->input())->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        @for ($i = 1; $i <= $Results->lastPage(); $i++)
        <li class="page-item {{ $i == $Results->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $Results->appends(request()->input())->url($i) }}">{{ $i }}</a>
        </li>
        @endfor

        <li class="page-item {{ $Results->currentPage() == $Results->lastPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $Results->appends(request()->input())->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
@else
<p>No search results found.</p>
@endif

@foreach($Results as $reservation)
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

       @foreach($Results as $reservation)
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











@endsection
