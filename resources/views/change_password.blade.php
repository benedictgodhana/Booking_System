<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
</head>

<body>
    <h1>Change Password</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (!Auth::check() || !Auth::user()->activated)
    <p>You are not authorized to change your password.</p>
    @else
    <form method="POST" action="{{ route('change-password.post') }}">
        @csrf

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <button type="submit">Change Password</button>
    </form>
    @endif

    <!-- Display any error messages here -->
</body>

</html>