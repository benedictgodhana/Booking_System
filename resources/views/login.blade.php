<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link style="max-width:20px" rel="icon" type="image/x-icon" href="/logo/LOGO_2.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <!-- SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }

        .login-page {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-box {
            width: 600px;
            max-width: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: -150px;
            margin-right: 50px;
        }

        .card-body {
            padding: 30px;
        }

        .login-logo img {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin: 0 auto 20px;
            display: block;
        }

        .icheck-primary input:checked+label::before {
            border-color: #007bff;
            background-color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .password-reset-card {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            /* Align content to the right */
            margin-top: -530px;
            /* Adjust the top margin as needed */
            margin-left: 1000px;
            /* Adjust the right margin as needed */
        }
        @media (max-width: 576px) {

            .login-box {
            width:100%;
            max-width:400px;
            size: 100px;
            background: #fff;
            padding: 20px;
            margin-top:10px;
            margin-right: 0px;
            height:auto;
        }
        .login-logo img {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin: 0 auto 20px;
            display: block;
        }
        .btn-success {
            width:100px;
            margin-left: -120px;

        }
        

        

        }

    </style>
</head>

<body class="hold-transition login-page" style="background-color:darkblue;">

    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-neutral">
            <div class="card-header text-center">
                <div class="login-logo">
                    <img src="logo/LOGO_2.png" alt="Logo">
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login to start your session</p>

                <form action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="input-group mb-3">
                        <input style="border:1px solid #ccc" id="email" type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <!-- ... Other form fields ... -->
                    <div class="input-group mb-3">
                        <input style="border:1px solid #ccc" id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <!-- /.col -->
                    <div class="col-4" style="margin-right:10px; margin-left: 198px">
                        <button type="submit" value="Submit" class="btn btn-success btn-block">
                            <i class="fas fa-sign-in-alt"></i> Log in
                        </button>
                        @include('sweet::alert')
                    </div>
                    <!-- /.col -->
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Footer -->
    <footer style="color:white;font-size:17px;font-weight:800" class="text-center mt-4">
        Strathmore University. All Rights Reserved. &copy; 2023 Strathmore
    </footer>
    <!-- /.login-box -->

    <!-- Button to trigger the modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#quickLinksModal">Quick Links</button>

    <!-- Modal for Quick Links -->
    <div class="modal fade" id="quickLinksModal" tabindex="-1" role="dialog" aria-labelledby="quickLinksModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickLinksModalLabel">Quick Links</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Quick Links content goes here -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="mb-0"><i class="fas fa-key mr-2"></i> Forgot your password?</p>
                        <a href="{{ route('password.request') }}" class="text-info"><i style="margin-left:20px"
                                class="fas fa-unlock-alt mr-1"></i>Reset Password</a>
                    </div>
                    <hr>
                    <p class="mb-2">
                        <i class="fas fa-user-plus mr-2"></i> <a href="{{ route('account.activate') }}"
                            class="text-info">New user?</a>
                    </p>
                    <hr>
                    <p class="mb-0">
                        <i class="fas fa-home mr-2"></i> <a href="/" class="text-info">Home</a>
                    </p>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script>
        function showAlert(title, message, icon, timer = 6000) {
            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                timer: timer, // Adjust the time you want the alert to be visible (in milliseconds),
                showConfirmButton: false // Hide the "OK" button
            });
        }

        function validateForm() {
            // Perform form validation here
            var email = document.getElementById('email');
            var password = document.getElementById('password');

            if (email.value === '' || password.value === '') {
                // Show a SweetAlert error notification
                showAlert('Error', 'Please fill in all fields', 'error');
                return false; // Prevent form submission
            }

            // Send an AJAX request to your server for login validation
            $.ajax({
                url: "{{ route('login.validate') }}", // Replace with your actual login validation route
                type: "POST",
                data: {
                    email: email.value,
                    password: password.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // If login is successful, display success message and redirect
                        showAlert('Success', 'Log in successfully!', 'success');
                        window.location.href = response.redirectTo;
                    } else {
                        // If login fails, display an error message
                        showAlert('Error', 'Incorrect email or password', 'error');
                    }
                },
                error: function() {
                    // Handle AJAX error, if any
                    showAlert('Error', 'An error occurred during login', 'error');
                }
            });

            return false; // Prevent form submission
        }
    </script>

</body>

</html>
