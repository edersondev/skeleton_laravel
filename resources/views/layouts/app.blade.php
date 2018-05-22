<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('components/fortawesome/web-fonts-with-css/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('components/adminlte/dist/css/adminlte.min.css') }}">
    @stack('css')

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  </head>
  <body>

    @yield('content')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ URL::asset('components/jquery/jquery.min.js') }}" ></script>
    <script src="{{ URL::asset('components/popper/dist/umd/popper.min.js') }}"></script>
    <script src="{{ URL::asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('components/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')

  </body>
</html>