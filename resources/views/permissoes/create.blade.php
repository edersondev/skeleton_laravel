@extends('layouts.app')

@section('title')
	<i class='fa fa-key'></i> {{ get_action_page(Route::currentRouteName()) }} Permissão
@endsection

@section('content')

@if( Route::currentRouteName() === 'permissoes.create' )
	{{ Form::open(['route' => 'permissoes.store']) }}
@else
	{{ Form::model($permission, array('route' => array('permissoes.update', $permission->co_seq_permissao), 'method' => 'PUT')) }}
@endif

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