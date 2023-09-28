<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
@if(session('status'))
<div class="alert alert-success" id="success-alert" style="width:800px;font-size:20px; text-align:center; font-weight:400px">
    {{ session('status') }}
</div>
<script>
    // Automatically hide the alert after 3 seconds (adjust the duration as needed)
    setTimeout(function() {
        document.getElementById("success-alert").style.display = "none";
    }, 4000);
</script>
@endif

<body class="hold-transition login-page" style="background-color:darkblue;">
    <div class="login-box">
        <div class="card card-outline card-neutral">
            <div class="card-header text-center">
                <div class="login-logo">
                    <img src="/logo/LOGO_2.png" alt="">
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Reset your password</p>

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input style="border:1px solid #ccc" type="email" name="email" class="form-control" placeholder="Email" required>
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
                            <button type="submit" class="btn btn-success btn-block">Send Password Reset Link</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="/login">Back to login</a>
                </p>
            </div>
        </div>
    </div>
    <footer style="color:white;font-size:17px;font-weight:800" class="text-center mt-4">
        Strathmore University. All Rights Reserved. &copy; 2023 Strathmore
    </footer>
</body>

</html>