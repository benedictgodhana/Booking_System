<!DOCTYPE html>
<html>

<head>
    <title>Account Activation</title>
</head>

<body>
    <h1>Account Activation</h1>

    @if ($user->activated)
    <p>Your account is already activated. You can log in.</p>
    @else
    <p>Your account is not activated yet.</p>
    <p>Click the button below to activate your account:</p>

    <a href="{{ route('activate', ['user' => $user, 'token' => $user->activation_token]) }}" class="btn btn-primary">Activate Account</a>
    @endif

    <!-- Display any error messages here -->
</body>

</html>