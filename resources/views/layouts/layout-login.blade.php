<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" >
  <link rel="stylesheet" href="{{asset('css/all.min.css')}}" >

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/components.css')}}">
</head>

<body>
  <div id="app">
    <section class="section">
        @yield('content')
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('js/jquery-3.3.1.min.js')}}" ></script>
  <script src="{{asset('js/popper.min.js')}}" ></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/jquery.nicescroll.min.js')}}"></script>
  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{asset('js/scripts.js')}}"></script>

  <!-- Page Specific JS File -->
</body>
</html>
