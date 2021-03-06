@if (session('success'))
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fa fa-check"></i> {{ session('success') }}
	</div>
@endif

@if (session('warning'))
	<div class="alert alert-warning alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
	</div>
@endif

@if (session('info'))
	<div class="alert alert-info alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fa fa-info"></i> {{ session('info') }}
	</div>
@endif

@if (session('danger'))
	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fa fa-ban"></i> {{ session('danger') }}
	</div>
@endif

@if (session('status'))
	<div class="alert alert-info alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fa fa-ban"></i> {{ session('status') }}
	</div>
@endif

@if (count($errors) > 0)
	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<p><i class="icon fa fa-ban"></i> Erros:</p>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif