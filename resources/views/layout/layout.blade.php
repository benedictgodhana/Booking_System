<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

  <title>RoomBooking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style>
    .navbar-light{
      background:#ec7d30;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar  elevation-4" style="background:darkblue">
    <a href="" class="brand-link">
      <img src="/logo/iLab white Logo-01.png" style="max-width:250px;height:150px;margin-left:-5px" alt="">
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img style="margin-left:10px" src="/logo/default-avatar-profile-image-vector-social-media-user-icon-400-228654854.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="color: white; font-weight: bold;">{{ auth()->user()->name }}</a>
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar bg-light">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if(auth()->user()->role == 1)
          <li class="nav-item" style="color:white">
            <a href="{{ route('sdashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt" style="color:white"></i>
              <p style="color:white">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('sadminreservation') }}" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:white"></i>
              <p style="color:white">
                All Reservations
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superAdminUsers') }}" class="nav-link">
              <i class="nav-icon fa fa-users" style="color:white"></i>
              <p style="color:white">
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superAdminItems') }}" class="nav-link">
              <i class="nav-icon fa fa-box" style="color:white"></i>
              <p style="color:white">
                Items
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superAdminDepartment') }}" class="nav-link">
              <i class="nav-icon fa fa-building" style="color:white"></i>
              <p style="color:white">
                Departments
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('manageRole') }}" class="nav-link">
              <i class="nav-icon fa fa-cogs" style="color:white"></i>
              <p style="color:white">
                Manage Roles
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadminactivities') }}" class="nav-link">
              <i class="nav-icon fa fa-history" style="color:white"></i>
              <p style="color:white">
                System Activities
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('superadmin.profile.show')}}" class="nav-link">
              <i class="nav-icon fa fa-user" style="color:white"></i>
              <p style="color:white">
                Profile
              </p>
            </a>
          </li>
          @endif

          @if(auth()->user()->role == 0)
          <li class="nav-item" style="color:white">
            <a  href="{{route('userdashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt" style="color:white"></i>
              <p style="color:white">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('booking') }}" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:white"></i>
              <p style="color:white">
                Book
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('reservation') }}" class="nav-link">
              <i class="nav-icon fa fa-users" style="color:white"></i>
              <p style="color:white">
                My Bookings
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a  href="{{route('user.profile.show')}}" class="nav-link">
              <i class="nav-icon fa fa-cogs" style="color:white"></i>
              <p style="color:white">
                Profile
              </p>
            </a>
          </li>
          
              @endif

              @if(auth()->user()->role == 3)
              <li class="nav-item" style="color:white">
            <a   href="{{ route('admindashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt" style="color:white"></i>
              <p style="color:white">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('adminreservation') }}" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:white"></i>
              <p style="color:white">
                Reservations
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a  href="{{route('admin.profile.show')}}" class="nav-link">
              <i class="nav-icon fa fa-cogs" style="color:white"></i>
              <p style="color:white">
                Profile
              </p>
            </a>
          </li>
         
              @endif

              @if(auth()->user()->role == 4)
              <li class="nav-item" style="color:white">
            <a   href="{{ route('minidashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt" style="color:white"></i>
              <p style="color:white">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('miniadminreservation') }}" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:white"></i>
              <p style="color:white">
                Reservations
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a  href="{{route('miniadmin.profile.show')}}" class="nav-link">
              <i class="nav-icon fa fa-cogs" style="color:white"></i>
              <p style="color:white">
                Profile
              </p>
            </a>
          </li>
              @endif
              @if(auth()->user()->role == 2)
              <li class="nav-item" style="color:white">
            <a   href="{{ route('subdashboard') }}"  class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt" style="color:white"></i>
              <p style="color:white">
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('subadminreservation') }}" class="nav-link">
              <i class="nav-icon fas fa-th" style="color:white"></i>
              <p style="color:white">
                Reservations
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a  href="{{route('subadmin.profile.show')}}" class="nav-link">
              <i class="nav-icon fa fa-cogs" style="color:white"></i>
              <p style="color:white">
                Profile
              </p>
            </a>
          </li>
              @endif
              <li class="nav-item">
            <a  href="/logout" class="nav-link">
              <i class="nav-icon fa fa-sign-out-alt" style="color:white"></i>
              <p style="color:white">
                Logout
              </p>
            </a>
          </li>
              
         
        </ul>
        <!-- Your navigation links here -->
      </nav>
    </div>
  </aside>
  <div class="content-wrapper" style="height:1000px ,                                                    /">
               <div id="content" style="background-color:#FAF9F6;" >
                <div style="margin: 4px; padding: 4px; width: auto; height: 86vh; overflow-x: hidden;">
                  @yield('space-work')
                </div>
              </div>
            
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

</body>
</html>
