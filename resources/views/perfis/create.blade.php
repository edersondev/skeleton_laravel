@extends('layouts.app')

@section('title')
	<i class='fa fa-key'></i> Adicionar Perfil
@endsection

@section('content')

{{ Form::open(['route' => 'perfis.store']) }}

<div class="row">
	<div class="col-6">

		<div class="card">
			<div class="card-body">
				{{ Form::bsText('ds_nome','Nome') }}

				<h5><b>Associar permissões</b></h5>
				<div class='form-group'>
					@foreach ($permissions as $permission)
						{{ Form::checkbox('permissions[]',  $permission->co_seq_permissao ) }}
						{{ Form::label($permission->ds_nome, ucfirst($permission->ds_nome)) }}<br>
					@endforeach
				</div>

			</div>
			<div class="card-footer">
				@form_buttons(['routeCancel' => route('perfis.index'),'routeName' => Route::currentRouteName()])
				@endform_buttons
			</div>
		</div>

	</div>
</div>

{{ Form::close() }}

@endsection