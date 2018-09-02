@extends('layouts.app')

@push('css')
	<link rel="stylesheet" href="{{ URL::asset('components/titatoggle/titatoggle-dist-min.css') }}">
@endpush

@section('title')
	@php
		$icon = ( Route::currentRouteName() === 'usuarios.create' ? 'plus' : 'edit' );
	@endphp
	<i class="fas fa-user-{{ $icon }}"></i> {{ get_action_page(Route::currentRouteName()) }} Usuário
@endsection

@section('content')

@if( Route::currentRouteName() === 'usuarios.create' )
	{{ Form::open(['route' => 'usuarios.store']) }}
@else
	{{ Form::model($user, array('route' => array('usuarios.update', $user->co_seq_usuario), 'method' => 'PUT')) }}
@endif

	<div class="card">
		<div class="card-body">

			<div class="row">
				<div class="col-md">

						<div class="card">
							<div class="card-header">
								<i class="fas fa-address-card"></i> Dados do usuário
							</div>
							<div class="card-body">
								{{ Form::bsText('ds_nome','Nome') }}
								{{ Form::bsEmail('email','Email') }}
								
								@php
									$helpTextPassword = ( Route::currentRouteName() === 'usuarios.create' ? null : 'Deixe o campo em branco para manter a mesma senha.' );		
								@endphp
								{{ Form::bsPassword('password','Senha',$helpTextPassword) }}
								{{ Form::bsPassword('password_confirmation',' Confirmar Senha') }}

								{{ Form::bsSelect('select','Teste',['L' => 'Large', 'S' => 'Small'],null,'texto de ajuda',['placeholder'=>'Selecione o item']) }}

								{{ Form::bsTitaCheckbox('st_ativo','Usuário ativo?',1,( isset($user->st_ativo) ? $user->st_ativo : 0 )) }}
							</div>
						</div>

				</div>
				<div class="col-md">

					<div class="card">
						<div class="card-header">
							<i class="fas fa-key"></i> Atribuir Perfil
						</div>
						<div class="card-body">
								@if(count($roles))
									@foreach ($roles as $role)
										@php
											$checked = null;
											if(Route::currentRouteName() === 'usuarios.edit'){
												$checked = ( in_array($role->co_seq_perfil,$usuario_perfis) ? true : false );
											}
										@endphp
										{{ Form::bsCheckbox('roles[]',ucfirst($role->ds_nome),$role->co_seq_perfil, $checked,['id' => "item_" . $loop->iteration]) }}
									@endforeach
								@else
									<h5><b>Nenhum perfil cadastrado</b></h5>
								@endif
						</div>
					</div>

				</div>
			</div>

		</div>

		<div class="card-footer">
			@form_buttons(['routeCancel' => route('usuarios.index'),'routeName' => Route::currentRouteName()])
			@endform_buttons
		</div>
		
	</div>
{{ Form::close() }}

@endsection