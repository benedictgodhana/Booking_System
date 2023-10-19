@extends('layout/layout')

@section('space-work')

<style>
    /* Custom Styles */
    .user-management {
        background-color: #f5f5f5;
        padding: 20px;
    }

    .user-table {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .user-table h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .user-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .user-table th,
    .user-table td {
        border: 1px solid #e0e0e0;
        padding: 12px;
        text-align: left;
    }

    .user-table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .user-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .user-table tbody tr:hover {
        background-color: #e0e0e0;
    }

    .user-table .action-buttons {
        display: flex;
        justify-content: flex-start;
    }

    .user-table .action-buttons button {
        margin-right: 10px;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pagination {
        margin-top: 20px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    .pagination li {
        list-style: none;
        display: inline-block;
        margin-right: 8px;
    }

    .pagination li a {
        padding: 6px 12px;
        text-decoration: none;
        background-color: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        color: #333;
    }

    .pagination li.active a {
        background-color: #007BFF;
        color: #fff;
        border: 1px solid #007BFF;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .user-table table {
            font-size: 14px;
        }

        .user-table .action-buttons {
            flex-direction: column;
        }

        .user-table .action-buttons button {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }
</style>

<div style="margin: 4px, 4px; padding: 4px; width: auto; height: 86vh; overflow-x: hidden; overflow-y: scroll;">

    <div class="user-management">
        <div class="user-table">
            <h2 class="mb-4">User Management</h2>
            <div>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-user-plus"></i> Add User</button>

                <button type="button" class="btn btn-secondary" onclick="printData()">
                    <i class="fas fa-print"></i> Print
                </button>
                <a href="{{ url('/export-users') }}" type="button" class="btn btn-success" onclick="exportData()">
                    <i class="fas fa-file-export"></i> Export
                </a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importDataModal">
                    <i class="fas fa-file-import"></i> Import
                </button>
            </div><br><br>

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="roleFilter">Filter by Role:</label>
                            <select class="form-control" id="roleFilter" onchange="filterAndSearch()">
                                <option value="">All</option>
                                <option value="Users">User</option>
                                <option value="SuperAdmin">SuperAdmin</option>   
                                <option value="SubAdmin">SubAdmin</option>
                                <option value="MiniAdmin">MiniAdmin</option> 
                                <option value="Admin">Admin</option>       
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="userSearch">Search Users:</label>
                        <input type="text" class="form-control" id="userSearch" placeholder="Search by name or email" onkeyup="filterAndSearch()">
                        </div>
                    </div>
                    
                </div>
            </div>
            @if (Session::has('success'))
            <div class="alert alert-success" id="success-alert">
                {{ Session::get('success') }}
            </div>
            <script>
                // Function to hide the success message after a delay
                function hideSuccessAlert() {
                    var alert = document.getElementById('success-alert');
                    if (alert) {
                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 5000); // Adjust the delay in milliseconds (e.g., 5000ms = 5 seconds)
                    }
                }

                // Call the hideSuccessAlert function when the page loads
                window.onload = function() {
                    hideSuccessAlert();
                };
            </script>

            @endif

            <!-- Modify the table structure in your blade file -->
            <table class="table" id="userTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td style="word-wrap: break-word; max-width: 150px;">{{ $user->department }}</td>
                        <td>{{ $user->is_guest ? 'Guest' : 'Normal User' }}</td>

                        <td class="action-buttons">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#viewUserModal{{ $user->id }}">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                <i class="fas fa-edit"></i> Edit User
                            </button>
                            @if($user->activated)
                            <button style="width:120px" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deactivateUserModal{{ $user->id }}">
                                <i class="fas fa-ban"></i> Deactivate
                            </button>
                            @else
                            <button style="width:120px" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#activateUserModal{{ $user->id }}">
                                <i class="fas fa-check-circle"></i> Activate
                            </button>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor

                            <li class="page-item {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
    <!-- Modal for Viewing User -->
    <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 style="margin-left:150px" class="modal-title" id="viewUserModalLabel{{ $user->id }}">View User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> Name:</strong> {{ $user->name }}</p>
                        </div><hr>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $user->email }}</p>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user-tag"></i> Role:</strong>
                                @if ($user->roles == null)
                                User
                                @else
                                {{ $user->roles->name }}
                                @endif
                            </p>
                        </div><hr>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-building"></i> Department:</strong> {{ $user->department }}</p>
                        </div>
                    </div>
                </div><hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
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
                <div class="modal-header bg-primary">
                    <h5 style="margin-left:150px" class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- User Edit Form -->
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <!-- Name Field -->
                            <label for="name"><i class="fas fa-user"></i> Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <!-- Email Field -->
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div>
                        <label for="userType"><i class="fas fa-user"></i> User Type</label>
                        <select name="is_guest" required class="form-control">
                            <option value="0" {{ $user->is_guest === 0 ? 'selected' : '' }}>Normal User</option>
                            <option value="1" {{ $user->is_guest === 1 ? 'selected' : '' }}>Guest</option>
                        </select>
                    </div>
                        <div class="form-group">
                            <!-- Password (Optional) -->
                            <label for="password"><i class="fas fa-lock"></i> Password (Optional)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-group">
                            <!-- Role Field -->
                            <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                            <select name="role" required class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                                <option value="0">User</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </form>
                    <!-- End User Edit Form -->
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 style="margin-left:350px" class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- User Add Form -->
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <!-- Name Field -->
                            <div class="form-group col-md-6">
                                <label for="name"><i class="fas fa-user"></i> Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-md-6">
                                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Password Field -->
                            <div class="form-group col-md-6">
                                <label for="password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <!-- Role Field -->
                            <div class="form-group col-md-6">
                                <label for="role"><i class="fas fa-user-tag"></i> Role</label>
                                <select name="role" required class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    <option value="0">User</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Department Field -->
                            <div class="form-group col-md-6">
                                <label for="department"><i class="fas fa-building"></i> Department</label>
                                <select name="department" id="department" class="form-control">
                                    <option value="eHealth">eHealth</option>
                                    <option value="IT Outsourcing & BITCU">IT Outsourcing & BITCU</option>
                                    <option value="Digital Learning">Digital Learning</option>
                                    <option value="Data Science">Data Science</option>
                                    <option value="IoT">IoT</option>
                                    <option value="IT Security">IT Security</option>
                                    <option value="iBizAfrica">iBizAfrica</option>
                                    <option value="IR & EE">IR & EE</option>
                                    <option value="PR">PR</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>

                            <!-- Other Department Field (Initially Hidden) -->
                            <div class="form-group col-md-6" id="otherDepartmentField" style="display: none;">
                                <label for="other_department"><i class="fas fa-building"></i> Other Department</label>
                                <input type="text" class="form-control" id="other_department" name="other_department">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add User</button>
                    </form>
                    <!-- End User Add Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- Import Data Modal -->
    <div class="modal fade" id="importDataModal" tabindex="-1" role="dialog" aria-labelledby="importDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importDataModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for data import -->
                    <form action="{{ route('import.data') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose File:</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($users as $user)
    <!-- Activation Modal -->
    <div class="modal fade" id="activateUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activateUserModalLabel">Activate User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to activate this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('user.activate', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Activate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach ($users as $user)

    <!-- Deactivation Modal -->
    <div class="modal fade" id="deactivateUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deactivateUserModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deactivateUserModalLabel{{ $user->id }}">Deactivate User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to deactivate this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="post" action="{{ route('deactivate.user', ['user' => $user]) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger">Deactivate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
<script>
    // Get references to the select and other department input field
    const departmentSelect = document.getElementById('department');
    const otherDepartmentField = document.getElementById('otherDepartmentField');

    // Add an event listener to the select field
    departmentSelect.addEventListener('change', function() {
        // Check if the selected option is "Others"
        if (departmentSelect.value === 'Others') {
            // Show the other department input field
            otherDepartmentField.style.display = 'block';
        } else {
            // Hide the other department input field
            otherDepartmentField.style.display = 'none';
        }
    });
</script>
<script>
    // Function to filter and search
    function filterAndSearch() {
        // JavaScript code for filtering and searching
    }

    // Event listeners for filter and search inputs
    document.getElementById('roleFilter').addEventListener('change', filterAndSearch);
    document.getElementById('userSearch').addEventListener('input', filterAndSearch);

    // Initial filtering and searching
    filterAndSearch();
</script>

<script>
    // JavaScript function to filter and search table rows
    function filterAndSearch() {
        // Get selected filter value
        var filter = document.getElementById("roleFilter").value.toLowerCase();
        // Get search input value
        var search = document.getElementById("userSearch").value.toLowerCase();
        // Get the table rows
        var rows = document.getElementById("userTable").getElementsByTagName("tr");

        // Loop through all table rows
        for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip the table header row
            var row = rows[i];
            var user = row.getElementsByTagName("td")[0].textContent.toLowerCase(); // Get user column value
            var name = row.getElementsByTagName("td")[1].textContent.toLowerCase(); // Get name column value
            var email = row.getElementsByTagName("td")[2].textContent.toLowerCase(); // Get email column value
            var role = row.getElementsByTagName("td")[3].textContent.toLowerCase(); // Get role column value
            var department = row.getElementsByTagName("td")[4].textContent.toLowerCase(); // Get department column value

            // Check if the row matches the filter and search criteria
            var filterMatch = (filter === "" || filter === "all" || (filter === "Admin" && role === "Admin") || (filter === "subadmin" && role === "SubAdmin"));
            var searchMatch = (search === "" || user.includes(search) || name.includes(search) || email.includes(search) || role.includes(search) || department.includes(search));

            if (filterMatch && searchMatch) {
                row.style.display = ""; // Show the row
            } else {
                row.style.display = "none"; // Hide the row
            }
        }
    }
</script>


@endsection