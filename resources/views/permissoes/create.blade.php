@extends('layouts.app')

@section('title')
	<i class='fa fa-key'></i> Adicionar Permissão
@endsection

@section('content')

{{ Form::open(['route' => 'permissoes.store']) }}

	<div class="row">
		<div class="col-6">
			<div class="card">
				<div class="card-body">
					{{ Form::bsText('ds_nome','Nome') }}

					@if(!$roles->isEmpty())
						<h4>Associar permissão para os perfis</h4>
						@foreach ($roles as $role) 
							{{ Form::checkbox('roles[]',  $role->id ) }}
							{{ Form::label($role->name, ucfirst($role->name)) }}<br>
						@endforeach
					@endif

				</div>
				<div class="card-footer">
					@form_buttons(['routeCancel' => route('permissoes.index'),'routeName' => Route::currentRouteName()])
					@endform_buttons
				</div>
			</div>
		</div>
	</div>

{{ Form::close() }}

@endsection