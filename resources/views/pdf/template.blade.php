<!DOCTYPE html>
<html>
<head>
    <style>
        /* Define your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            border: 2px solid #007bff; /* Blue border around the page */
            padding: 10px;
        }

        h1 {
            text-align: center;
            color: #007bff; /* Blue color for the title */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            border-radius: 20px;
        }

        td {
            border: 1px solid #333;
            padding: 8px;
            background-color: #f2f2f2;
            font-size: 12px;
            border-radius: 20px;
            font-family: 'Times New Roman', Times, serif;
        }

        th {
            border: 1px solid #333;
            padding: 13px;
            background-color: #f2f2f2;
            font-size: 14px;
            border-radius: 20px;
            font-family: 'Times New Roman', Times, serif;
            font-weight: 900;
        }

        /* Center the logo and title */
        .logo-title {
            text-align: center;
        }

        /* Footer style */
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
            color: #888; /* Gray color for the footer */
        }
    </style>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Header: Logo and Title -->
    <div class="logo-title">
        <img src="/logo/LOGO_2.png" alt="Logo" width="150">
        <h1 style="color: black; margin-left: 20px; margin-top: 30px">System Activities Report</h1>
    </div>

    <!-- Table with Bootstrap classes -->
    <table class="table table-bordered table-striped" style="border-radius: 20px">
        <thead>
            <tr>
                <th>User</th> <!-- Blue header with white text -->
                <th>Action</th> <!-- Green header with white text -->
                <th>Description</th> <!-- Red header with white text -->
                <th>Timestamp</th> <!-- Yellow header with black text -->
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
            <tr>
                <td>
                    @if ($activity->user)
                    {{ $activity->user->name }}
                    @else
                    User not found
                    @endif
                </td>
                <td>{{ $activity->action }}</td>
                <td>{{ $activity->description }}</td>
                <td>{{ $activity->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Strathmore - All rights are reserved
    </div>
</body>
</html>
