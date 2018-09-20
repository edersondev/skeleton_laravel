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
		<link rel="stylesheet" href="{{ URL::asset('components/fortawesome/web-fonts-with-css/css/fontawesome-all.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/errors/error.css') }}">
		@stack('css')

		<link href="{{ URL::asset('favicon.ico') }}" rel="shortcut icon" type="image/x-icon">

	</head>
	<body>

		{{-- <div class="container">
			<h1>@yield('title','Título da página')</h1>
			@yield('content')
		</div> --}}
		<div class="overlay"></div>
		<div class="terminal">
			@hasSection('title')
				<h1>@yield('title','Título da página')</h1>
			@endif
			@yield('content')
		</div>

		<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- jQuery -->
    <script src="{{ URL::asset('components/jquery/jquery.min.js') }}" ></script>
    <!-- Bootstrap 4 -->
		<script src="{{ URL::asset('components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		@stack('js')
	</body>
</html>