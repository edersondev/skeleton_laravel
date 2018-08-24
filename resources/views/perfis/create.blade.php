@extends('layouts.app')

@section('title')
	<i class='fa fa-key'></i> {{ get_action_page(Route::currentRouteName()) }} Perfil
@endsection

@section('content')

@if( Route::currentRouteName() === 'perfis.create' )
	{{ Form::open(['route' => 'perfis.store']) }}
@else
	{{ Form::model($role, array('route' => array('perfis.update', $role->co_seq_perfil), 'method' => 'PUT')) }}
@endif
<div class="row">
	<div class="col-6">

		<div class="card">
			<div class="card-body">
				{{ Form::bsText('ds_nome','Nome') }}

				<fieldset>
					<legend>Associar permissões</legend>
					@foreach ($permissions as $permission)
						@php
							$checked = null;
							if(Route::currentRouteName() === 'perfis.edit'){
								$checked = ( in_array($permission->co_seq_permissao,$perfil_permissoes) ? true : false );
							}
						@endphp
						{{ Form::bsCheckbox('permissions[]',ucfirst($permission->ds_nome),$permission->co_seq_permissao, $checked,['id' => "item_" . $loop->iteration]) }}
					@endforeach
				</fieldset>
					
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