@extends('layout/layout') <!-- Include your layout file if you have one -->

@section('space-work')
<div class="card">
<div class="card-body">

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
    Add Department
</button>

    <h2>Departments</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal{{ $department->id }}">Edit</button>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $department->id }}">Delete</button>
                    <!-- Add buttons for actions like edit and delete -->
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Modal for Adding Department -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form for adding departments here -->
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="departmentName">Department Name</label>
                        <input type="text" class="form-control" id="departmentName" name="name" placeholder="Enter Department Name">
                    </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit"  class="btn btn-primary">Save</button> <!-- Submit button -->
            </div>
                </form>
            </div>
           
        </div>
    </div>
</div>


@foreach ($departments as $department )

<div class="modal fade" id="editModal{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $department->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Add your edit form here -->
            <form action="{{ route('departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $department->id }}">Edit Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
            <label for="name">Department Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}">
             </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

@foreach ($departments as $department )
<div class="modal fade" id="deleteModal{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $department->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $department->id }}">Delete Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this department?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
