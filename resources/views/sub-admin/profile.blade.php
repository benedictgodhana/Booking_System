@extends('layout/layout')

@section('space-work')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div style="margin-left: 50px" class="container-xl px-4 mt-4">
    <!-- Account page navigation-->

    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img style="margin-left:-30px;max-width:300px" class="img-account-profile rounded-circle mb-2"
                        src="/logo/default-avatar-profile-image-vector-social-media-user-icon-400-228654854.jpg" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                <form method="POST" action="{{ route('updateprofilePassword') }}" onsubmit="return validateForm()">
                     @csrf                            <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Username (how your name will appear to other
                                users on the site)</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Enter your name"
                                value="{{ Auth::user()->name }}">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Full Name</label>
                                <input class="form-control" id="inputFirstName" type="text"
                                   name="name" placeholder="Enter your namee" value="{{ Auth::user()->name }}">
                            </div>
                            <!-- Form Group (last name)-->
                        
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Department/Unit</label>
                                <input class="form-control" id="inputOrgName" type="text"
                                   name="department" placeholder="Enter your department" value="{{ Auth::user()->department}}">
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Role</label>
                                <input class="form-control" id="inputLocation" type="text"
                                   name="role" placeholder="Enter your role" value="{{ Auth::user()->roles->name }}" readonly>
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email"
                               name="email" placeholder="Enter your email address" value="{{ Auth::user()->email}}">
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Current Password</label>
                            <div class="input-group">
                                <input type="password" name="current_password" class="form-control" id="current_password" required placeholder="Enter your current Password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="hide_current_password">
                                        Show
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">New Password</label>
                            <div class="input-group">
                                <input type="password" name="new_password" id="new_password" class="form-control" required placeholder="Enter your New Password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="show_new_password">
                                        Show
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required placeholder="Confirm your current Password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="show_confirmation_password">
                                        Show
                                    </button>
                                </div>
                            </div>
                        </div>
                                                    <!-- Form Row-->
                                                    
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
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
function togglePasswordVisibility(inputId, buttonId) {
const passwordInput = document.getElementById(inputId);
const button = document.getElementById(buttonId);

if (passwordInput.type === 'password') {
    passwordInput.type = 'text'; // Show password
    button.textContent = 'Hide';
} else {
    passwordInput.type = 'password'; // Hide password
    button.textContent = 'Show';
}
}

// Add event listeners for toggling password visibility
document.getElementById('hide_current_password').addEventListener('click', function () {
togglePasswordVisibility('current_password', 'hide_current_password');
});

document.getElementById('show_new_password').addEventListener('click', function () {
togglePasswordVisibility('new_password', 'show_new_password');
});

document.getElementById('show_confirmation_password').addEventListener('click', function () {
togglePasswordVisibility('new_password_confirmation', 'show_confirmation_password');
});

</script>

    @endsection
