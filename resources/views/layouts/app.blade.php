<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('components/fortawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('components/adminlte/dist/css/adminlte.min.css') }}">
    @stack('css')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="{{ URL::asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon">

  </head>
  <body class="hold-transition sidebar-mini">

    <!-- Site wrapper -->
    <div class="wrapper">
      
      @include('layouts.navbar.navbar')

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
          <img src="{{ URL::asset('components/adminlte/dist/img/AdminLTELogo.png') }}"
              alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        @include('layouts.sidebar')

      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>@yield('title','Título da página')</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Blank Page</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          
          @include('layouts.alerts')

          @yield('content')
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Version</b> 3.0.0-alpha. <strong>Laravel version:</strong> {{ app()->version() }}
        </div>
        <strong>Copyright &copy; 2014-{{date('Y')}} <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- jQuery -->
    <script src="{{ URL::asset('components/jquery/jquery.min.js') }}" ></script>
    <script src="{{ URL::asset('components/popper/umd/popper.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('components/adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('components/adminlte/dist/js/demo.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @stack('js')

  </body>
</html>