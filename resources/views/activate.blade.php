<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activate Account</title>

    <!-- Add your CSS styles here -->
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

<body class="hold-transition login-page" style="background-color:darkblue;">

@if(session('status'))
<div class="alert alert-success" id="success-alert">
    {{ session('status') }}
</div>
<script>
    // Automatically hide the alert after 3 seconds (adjust the duration as needed)
    setTimeout(function() {
        document.getElementById("success-alert").style.display = "none";
    }, 4000);
</script>
@endif

@if(session('error'))
<div class="alert alert-danger" id="success-alert">
    {{ session('error') }}
</div>
<script>
    // Automatically hide the alert after 3 seconds (adjust the duration as needed)
    setTimeout(function() {
        document.getElementById("success-alert").style.display = "none";
    }, 4000);
</script>
@endif
    <div class="login-box">
        <div class="card card-outline card-neutral">
            <div class="card-header text-center">
                <div class="login-logo">
                    <img src="/logo/LOGO_2.png" alt="Logo">
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Activate your account</p>

                <form action="{{ route('account.check-activation') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input style="border:1px solid #ccc;" id="email" type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block">Activate Account</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ url('/login') }}">Back to Login</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    <footer style="color:white;font-size:17px;font-weight:800" class="text-center mt-4">
        Strathmore University. All Rights Reserved. &copy; 2023 Strathmore
    </footer>
    <!-- Add your JavaScript scripts here -->

</body>

</html>