@extends('layout/layout')

@section('space-work')

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

<h2 class="mb-4">Users</h2>

<table class="table">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>

    </tr>
    @foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if ($user->roles == null)
            User
            @else

            {{ $user->roles->name }}

            @endif
        </td>
        <td>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#viewUserModal{{ $user->id }}">
                View
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                Edit User
            </button>



        </td>
    </tr>
    @endforeach
</table>


@foreach ($users as $user)
<!-- Modal for Viewing User -->
<div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel{{ $user->id }}">View User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong>
                    @if ($user->roles == null)
                    User
                    @else
                    {{ $user->roles->name }}
                    @endif
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach



@foreach ($users as $user)
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- User Edit Form -->
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>

                    <!-- Password (Optional) -->
                    <div class="form-group">
                        <label for="password">Password (Optional)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <!-- Role Field -->
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" required class="form-control" style="border: 1px solid;">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                            <option value="0">User</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" onclick="showAlert('Success', 'User updated successfully!', 'success')">Save Changes</button>
                </form>
                <!-- End User Edit Form -->
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
            timer: 9000, // Adjust the time you want the alert to be visible (in milliseconds)

        });
    }
</script>
@endsection