<!doctype html>
<html lang="en">

<head>
  <title>Room Booking App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <!-- Include Select2 CSS and JS from CDN -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
  <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('js/multiselect-dropdown.js') }}"></script>
  <style>
    .multiselect-dropdown {
      width: 100% !important;
    }

    /* Sidebar Styles */
    #wrapper {
      display: flex;
    }

    #sidebar {
      width: 250px;
      min-height: 100vh;
      background-color: #343a40;
      color: #fff;
    }

    #sidebar .sidebar-header {
      text-align: center;
      padding: 20px;
    }

    #sidebar ul.components {
      padding: 0;
    }

    #sidebar ul.components li {
      padding: 8px 15px;
      font-size: 16px;
      list-style-type: none;
    }

    #sidebar ul.components li a {
      color: #fff;
      text-decoration: none;
    }

    #sidebar ul.components li a i {
      margin-right: 10px;
    }

    #sidebar ul.components li.active {
      background-color: #007BFF;
    }

    #sidebar ul.components li.active a {
      color: #fff;
    }

    /* Content Styles */
    #content {
      flex-grow: 1;
      padding: 15px;
    }

    /* Media query for responsiveness */
    @media (max-width: 768px) {
      #wrapper {
        flex-direction: column;
      }

      #sidebar {
        width: 100%;
        display: none;
      }

      #content {
        width: 100%;
        padding: 20px;
      }

      /* Style the sidebar header */
      .sidebar-header {
        background-color: #333;
        /* Background color */
        color: #fff;
        /* Text color */
        padding: 20px;
        /* Add some padding for spacing */
      }

      /* Style the h3 element (Room Booking) */
      .sidebar-header h3 {
        font-size: 24px;
        /* Adjust the font size */
        margin-bottom: 10px;
        /* Add some spacing between the h3 and p elements */
      }

      /* Style the p element (Welcome, user's name) */
      .sidebar-header p {
        font-size: 18px;
        /* Adjust the font size */
        font-weight: bold;
        /* Make it bold */
      }

    }
  </style>
</head>

<body>
  <div id="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
      <div class="sidebar-header" style="background-color:#007BFF;color: #fff;">
        <h3 style="font-size: 20px;margin-bottom: 10px;">Room Booking System</h3>
        <hr style="border-color: white;">
        <p style=" font-size: 18px;font-weight: bold;">Welcome, {{ Auth::user()->name }}</p> <!-- Display the user's name here -->
      </div>

      <ul class="list-unstyled components">
        <!-- Common menu items -->

        <!-- Different menus based on user role -->
        @if(auth()->user()->role == 1)
        <!-- Admin menu -->
        <li>
          <a href="{{ route('sdashboard') }}"><i class="fa fa-tachometer-alt"></i> Admin Dashboard</a>
        </li>
        <li>
          <a href="{{ route('sadminreservation') }}"><i class="fa fa-calendar"></i> Reservation</a>
        </li>
        <li>
          <a href="{{ route('superAdminUsers') }}"><i class="fa fa-users"></i> Users</a>
        </li>
        <li>
          <a href="{{ route('manageRole') }}"><i class="fa fa-cogs"></i> Manage Role</a>
        </li>
        <li>
          <a href="{{ route('superadminactivities') }}"><i class="fa fa-history mr-3"></i>System Activities</a>
        </li>
        <li>
          <a href="{{route('superadmin.profile.show')}}"><i class="fa fa-user"></i> Profile</a>
        </li>

        @endif

        @if(auth()->user()->role == 0)
        <!-- User menu -->
        <li>
          <a href="{{route('userdashboard')}}"><i class="fa fa-tachometer-alt"></i>Dashboard</a>
        </li>
        <li>
          <a href="{{ route('booking') }}"><i class="fa fa-building"></i> Booking</a>
        </li>
        <li>
          <a href="{{ route('reservation') }}"><i class="fa fa-calendar"></i> Reservation</a>
        </li>
        <li>
          <a href="{{route('user.profile.show')}}"><i class="fa fa-user"></i> Profile</a>
        </li>


        @endif

        @if(auth()->user()->role == 2)
        <!-- Sub-admin menu -->
        <li>
          <a href="{{ route('subdashboard') }}"><i class="fa fa-tachometer-alt"></i> Admin Dashboard</a>
        </li>
        <li>
          <a href="{{ route('subadminreservation') }}"><i class="fa fa-calendar"></i> Reservation</a>
        </li>
        <li>
          <a href="{{route('subadmin.profile.show')}}"><i class="fa fa-user"></i> Profile</a>
        </li>


        @endif

        @if(auth()->user()->role == 3)
        <!-- Admin menu -->
        <li>
          <a href="{{ route('admindashboard') }}"><i class="fa fa-tachometer-alt"></i> Admin Dashboard</a>
        </li>
        <li>
          <a href="{{ route('adminreservation') }}"><i class="fa fa-calendar"></i> Reservation</a>
        </li>
        <li>
          <a href="{{route('admin.profile.show')}}"><i class="fa fa-user"></i> Profile</a>
        </li>

        @endif

        @if(auth()->user()->role == 4)
        <!-- Mini-admin menu -->
        <li>
          <a href="{{ route('minidashboard') }}"><i class="fa fa-tachometer-alt"></i> Admin Dashboard</a>
        </li>
        <li>
          <a href="{{ route('miniadminreservation') }}"><i class="fa fa-calendar"></i> Reservation</a>
        </li>
        <li>
          <a href="{{route('miniadmin.profile.show')}}"><i class="fa fa-user"></i> Profile</a>
        </li>


        @endif

        <!-- Logout -->
        <li>
          <a href="/logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </nav>

    <!-- Page Content -->
    <div id="content" style="background-color:#FAF9F6;">
      @yield('space-work')
    </div>
  </div>

  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>