@extends('layout/layout')

@section('space-work')
<style>
    /* Style the pagination container */
/* Style the simple pagination container */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Style the individual pagination links */
.pagination .page-item {
    margin: 0 5px;
    list-style: none;
}

/* Style the current/active page link */
.pagination .page-item.active .page-link {
    background-color: #007bff; /* Change to your preferred color */
    border-color: #007bff; /* Change to your preferred color */
    color: #fff; /* Text color for active page */
}

/* Style the previous and next page links */
.pagination .page-item .page-link {
    color: #007bff; /* Text color for non-active pages */
    border: 1px solid #007bff; /* Border color for non-active pages */
    border-radius: 4px;
}

/* Style on hover for previous and next page links */
.pagination .page-item .page-link:hover {
    background-color: #007bff; /* Change to your preferred color */
    border-color: #007bff; /* Change to your preferred color */
    color: #fff; /* Text color on hover */
}

</style>


@if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
<script>
    // Wait for the document to be ready
    $(document).ready(function () {
        // Check if the success alert element exists
        var successAlert = $('#success-alert');
        if (successAlert.length) {
            // Automatically close the alert after 5 seconds (adjust the time as needed)
            setTimeout(function () {
                successAlert.alert('close'); // Close the alert
            }, 5000); // 5000 milliseconds (5 seconds)
        }
    });
</script>



<div class="card">
<div class="card-body">

<button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Room</button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($rooms as $room)
            <tr>
                <td>{{$room->name}}</td>
                <td>{{$room->description}}</td>
                <td>{{$room->capacity}}</td>
                <td>
                <button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$room->id}}">Edit</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$room->id}}">Delete</button>
                </td>   
                </td>
            </tr>
            @endforeach
        </tbody> 
    </table>
    <div class="pagination">
    {{ $rooms->links() }}
</div>
</div>











@foreach($rooms as $room)
<!-- Edit Modal -->
<!-- Edit Room Modal -->
<div class="modal fade" id="editModal{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$room->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$room->id}}">Edit Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Room Form -->
                <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$room->name}}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{$room->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" value="{{$room->capacity}}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                <!-- End Edit Room Form -->
            </div>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{$room->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$room->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{$room->id}}">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the room: <strong>{{$room->name}}</strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Add Room Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add Room Form -->
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
                <!-- End Add Room Form -->
            </div>
        </div>
    </div>
</div>

@endforeach
@endsection
