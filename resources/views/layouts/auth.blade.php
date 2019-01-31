<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Autenticação</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('components/fortawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('components/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    @stack('css')

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="{{ URL::asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon">

  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        {{ config('app.name') }}
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          @include('layouts.alerts')
          @yield('content')
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- jQuery -->
    <script src="{{ URL::asset('components/jquery/jquery.min.js') }}" ></script>
    <script src="{{ URL::asset('components/popper/umd/popper.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    @stack('js')

  </body>

</html>