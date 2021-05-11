<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ config('app.name', 'PROMS') }} | @yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" >
  <link rel="stylesheet" href="{{asset('css/all.min.css')}}" >

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/components.css')}}">
  <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">

  @yield('styles')

</head>

<body class="{{(request()->is(['projects/*'])) ? 'sidebar-mini' : ''}}">

  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
              <div class="search-header">
                Histories
              </div>
              <div class="search-item">
                <a href="#">How to hack NASA using CSS</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">Kodinger.com</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">#Stisla</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-header">
                Result
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="#" alt="product">
                  oPhone S9 Limited Edition
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="#" alt="product">
                  Drone X2 New Gen-7
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="#" alt="product">
                  Headphone Blitz
                </a>
              </div>
              <div class="search-header">
                Projects
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-danger text-white mr-3">
                    <i class="fas fa-code"></i>
                  </div>
                  Stisla Admin Template
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-primary text-white mr-3">
                    <i class="fas fa-laptop"></i>
                  </div>
                  Create a new Homepage Design
                </a>
              </div>
            </div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('uploads/users')."/".Auth::user()->id."/".Auth::user()->profile_picture }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">{{Auth::user()->name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in 5 min ago</div>
              <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="btn w-100 "><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item {{(request()->is(['dashboard'])) ? 'active' : ''}}">
                <a href="{{route('dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
              <li class="menu-header">Projects</li>
              <li class="nav-item {{(request()->is(['projects','projects/*'])) ? 'active' : ''}}">
                <a href="{{route('projects.index')}}" class="nav-link"><i class="fas fa-columns"></i> <span>Projects</span></a>
              </li>
              <li class="menu-header">Users</li>
              <li class="nav-item {{(request()->is(['users'])) ? 'active' : ''}}">
                <a href="{{route('users.index')}}" class="nav-link"><i class="fas fa-users"></i> <span>Users</span></a>
              </li>
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      @yield('content')

      <footer class="main-footer">

    </footer>
  </div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('js/jquery-3.3.1.min.js')}}" ></script>
<script src="{{asset('js/popper.min.js')}}" ></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<!-- JS Libraies -->

<!-- Template JS File -->
<script src="{{asset('js/scripts.js')}}"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var success = "{{ Session::get('success')}}";
    var error = "{{ Session::get('error')}}";
    if (success) {
        toastr.success(success);
    }
    if (error) {
        toastr.error(error);
    }
</script>
@yield('script')

<!-- Page Specific JS File -->
</body>
</html>
