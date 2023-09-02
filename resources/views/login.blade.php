<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

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
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <div class="login-logo">
                    <img src="logo/LOGO_2png" alt="Logo">
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" name="email" class="form-control" placeholder="Email" required>
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
                        <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" value="Submit" class="btn btn-primary btn-block">Sign In</button>
                            @include('sweet::alert')
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="/register" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

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