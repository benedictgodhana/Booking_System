<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>register</title>

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

<body class="hold-transition login-page" style="background-color:#FAF9F6;">
    <div class="login-box">
        
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            
            <div class="card-header text-center">
                <div class="login-logo">
                    <img src="logo/LOGO_2.png" alt="Logo">
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register to start your session</p>

                <form action="{{ route('register') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="name" type="text" name="name" class="form-control" placeholder="Full Name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
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
                    <div class="input-group mb-3">
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select id="department" name="department" class="form-control">
                            <option value="eHealth">eHealth</option>
                            <option value="IT Outsourcing & BITCU">IT Outsourcing & BITCU</option>
                            <option value="Digital Learning">Digital Learning</option>
                            <option value="Data Science">Data Science</option>
                            <option value="IoT">IoT</option>
                            <option value="IT Security">IT Security</option>
                            <option value="iBizAfrica">iBizAfrica</option>
                            <option value="IR &EE">IR &EE</option>
                            <option value="PR">PR</option>
                            <option value="ADM">@iLab Admin</option>
                            <option value="Others">Other</option>
                        </select>
                    </div>
                    <div class="input-group mb-3" id="otherDepartmentField" style="display:none;">
                        <input id="otherDepartment" type="text" name="other_department" class="form-control" placeholder="Enter your department" style="width:500px">
                    </div>

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
                            <button type="submit" value="Submit" class="btn btn-primary btn-block">Sign Up</button>
                            @include('sweet::alert')
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->


                <p class="mb-0">
                    <a href="/login" class="text-center">Already a member</a>
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
            var name = document.getElementById('name');
            var email = document.getElementById('email');
            var password = document.getElementById('password');
            var password_confirmation = document.getElementById('password_confirmation');


            if (name.value === '' || email.value === '' || password.value === '' || password_confirmation.value === '') {
                // Show a SweetAlert error notification
                showAlert('Error', 'Please fill in all fields', 'error');
                return false; // Prevent form submission
            }

            showAlert('Success', 'Registration successful!', 'success');

        }
    </script>
    <script>
        // Function to toggle the "other department" field
        function toggleOtherDepartmentField() {
            var departmentSelect = document.getElementById('department');
            var otherDepartmentField = document.getElementById('otherDepartmentField');
            var otherDepartmentInput = document.getElementById('otherDepartment');

            if (departmentSelect.value === 'Others') {
                otherDepartmentField.style.display = 'block';
                otherDepartmentInput.style.display = 'block'; // Add this line to make the input field visible
                otherDepartmentInput.required = true;
            } else {
                otherDepartmentField.style.display = 'none';
                otherDepartmentInput.style.display = 'none'; // Add this line to hide the input field
                otherDepartmentInput.required = false;
            }
        }

        // Add an event listener to the department select
        document.getElementById('department').addEventListener('change', toggleOtherDepartmentField);

        // Call the function initially to set the initial state
        toggleOtherDepartmentField();
    </script>
</body>

</html>