@extends('layout/layout')

@section('space-work')
<style>
    /* Style for the profile container */
    .profile-container {
        max-width: 2000px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Style for the profile header */
    .profile-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-header h1 {
        font-size: 24px;
        color: #333;
    }

    /* Style for user information section */
    .user-info {
        margin-bottom: 20px;
    }

    .user-info strong {
        font-weight: bold;
    }

    /* Style for form section */
    .profile-form {
        margin-top: 20px;
    }

    /* Style for form labels */
    .profile-form label {
        font-weight: bold;
        color: #333;
    }

    /* Style for form inputs */
    .profile-form input[type="text"],
    .profile-form input[type="email"],
    .profile-form input[type="password"] {
        width: 50%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 15px;
        font-size: 16px;
    }

    /* Style for the "Change Password" button */
    .profile-form button {
        background-color: #007bff;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
    }

    /* Style for the "Change Password" button on hover */
    .profile-form button:hover {
        background-color: #0056b3;
    }

    /* Additional styles for responsiveness */
    @media (max-width: 768px) {
        .profile-container {
            padding: 10px;
        }

        .profile-header h1 {
            font-size: 20px;
        }

        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="password"] {
            font-size: 14px;
        }

        .profile-form button {
            padding: 10px 15px;
        }
    }
</style>
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif



<div class="profile-container">
    <h1 style="text-align:center">User's Profile</h1>
    <hr>

    <!-- Display user information -->
    <div class="form-group">
        <label for="name"><strong>Name:</strong></label>
        <p class="form-control-static">{{ Auth::user()->name }}</p>
    </div>
    <hr>

    <div class="form-group">
        <label for="email"><strong>Email:</strong></label>
        <p class="form-control-static">{{ Auth::user()->email }}</p>
    </div>
    <hr>

    <div class="form-group">
        <label for="department"><strong>Department:</strong></label>
        <p class="form-control-static">{{ Auth::user()->department }}</p>
    </div>
    <hr>
    <div class="form-group">
        <label for="department"><strong>Role:</strong></label>
        <p class="form-control-static">{{ Auth::user()->roles->name }}</p>
    </div>

    <hr>
    <div class="profile-form">
        <!-- Display SweetAlert2 alerts here -->
        <div id="passwordChangeAlert"></div>
        <!-- Password change form -->
        <form method="POST" action="{{ route('profile.updatePassword') }}" onsubmit="return validateForm()">
            @csrf
            <div class="form-group">
                <label for="current_password"><i class="fas fa-lock input-icon"></i> Current Password</label>
                <input type="password" name="current_password" class="form-control" required disabled value="{{ Auth::user()->password }}">
            </div>
            <div class="form-group">
                <label for="new_password"><i class="fas fa-lock input-icon"></i> New Password</label>
                <div style="width:50%" class="input-group">
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                    <div style="height:40px" class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" id="show_password"> Show
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="new_password_confirmation"><i class="fas fa-lock input-icon"></i>Confirm New Password</label>
                <div style="width:50%" class="input-group">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                    <div style="height:40px" class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" id="show_confirmation"> Show
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function validateForm() {
        // Get the values of the password inputs
        const currentPassword = document.querySelector('input[name="current_password"]').value;
        const newPassword = document.querySelector('input[name="new_password"]').value;
        const confirmPassword = document.querySelector('input[name="new_password_confirmation"]').value;

        // Define your validation logic here
        if (newPassword.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Password Error',
                text: 'Password must be at least 8 characters long.'
            });
            return false; // Prevent form submission
        }

        if (newPassword === currentPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Password Error',
                text: 'New password should not be the same as the current password.'
            });
            return false; // Prevent form submission
        }

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Password Error',
                text: 'New password and confirmation password do not match.'
            });
            return false; // Prevent form submission
        }


        // If all validations pass, the form will be submitted
        return true;
    }
</script>


<script>
    // Function to toggle password visibility
    function togglePasswordVisibility(inputId, checkboxId) {
        const passwordInput = document.getElementById(inputId);
        const checkbox = document.getElementById(checkboxId);

        if (checkbox.checked) {
            passwordInput.type = 'text'; // Show password
        } else {
            passwordInput.type = 'password'; // Hide password
        }
    }

    // Add event listeners for toggling password visibility
    document.getElementById('show_password').addEventListener('change', function() {
        togglePasswordVisibility('new_password', 'show_password');
    });

    document.getElementById('show_confirmation').addEventListener('change', function() {
        togglePasswordVisibility('new_password_confirmation', 'show_confirmation');
    });
</script>

@endsection