<!doctype html>
<html lang="en">

<head>
  <title>Room Booking App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
  <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
  <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{ asset('js/multiselect-dropdown.js') }}"></script>
  <style>
    .multiselect-dropdown {
      width: 100% !important;
    }
  </style>
</head>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <ul class="list-unstyled components mb-5">

        @if(auth()->user()->role == 1)
        <h1><a href="/" class="logo">Admin Dashboard</a></h1>

        <li>
          <a href="{{ route('sadminreservation') }}"><span class="fa fa-calendar mr-3"></span>Reservation</a>
        </li>
        <li>
          <a href="{{ route('superAdminUsers') }}"><span class="fa fa-users mr-3"></span> Users</a>
        </li>

        <li>
          <a href="{{ route('manageRole') }}"><span class="fa fa-users mr-3"></span> Manage Role</a>
        </li>
        @endif

        @if(auth()->user()->role == 0)
        <h1><a href="/dashboard" class="logo">User Dashboard</a></h1>

        <li>
          <a href="{{ route('booking') }}"><span class="fa fa-building mr-3"></span>Booking</a>
        </li>
        <li>
          <a href="{{ route('reservation') }}"><span class="fa fa-calendar mr-3"></span>Reservation Status</a>
        </li>
        @endif
        @if(auth()->user()->role == 2)
        <h1><a href="/dashboard" class="logo">SubAdmin Dashboard</a></h1>

        <li>
          <a href="{{ route('subadminreservation') }}"><span class="fa fa-calendar mr-3"></span>Reservation</a>
        </li>
        @endif

        @if(auth()->user()->role == 3)
        <h1><a href="/dashboard" class="logo">Admin Dashboard</a></h1>

        <li>
          <a href="{{ route('adminreservation') }}"><span class="fa fa-calendar mr-3"></span>Reservation</a>
        </li>
        @endif
        @if(auth()->user()->role == 4)
        <h1><a href="" class="logo">Mini Dashboard</a></h1>
        <li>
          <a href="{{ route('miniadminreservation') }}"><span class="fa fa-calendar mr-3"></span>Reservation</a>
        </li>

        <li>
        </li>
        @endif

        <li>
          <a href="/logout"><span class="fa fa-sign-out mr-3"></span><strong class="btn btn-success">{{ auth()->user()->name }}</strong> Logout</a>
        </li>
      </ul>

    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">

      @yield('space-work')
    </div>
  </div>

  <!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
  <script src="{{ asset('js/popper.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>