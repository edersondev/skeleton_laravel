@extends('layouts.app')

@section('title')
	<i class="fas fa-user-edit"></i> Editar Usuário
@endsection

@section('content')

{{ Form::model($user, array('route' => array('usuarios.update', $user->co_seq_usuario), 'method' => 'PUT')) }}
	
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
								{{ Form::bsPassword('password','Senha') }}
								{{ Form::bsPassword('password_confirmation',' Confirmar Senha') }}
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
									<div class='form-group'>
										@foreach ($roles as $role)
											{{ Form::checkbox('roles[]',  $role->id, $user->roles ) }}
											{{ Form::label($role->name, ucfirst($role->name)) }}<br>
										@endforeach
									</div>
								@else
									<h5><b>Nenhum perfil cadastrado</b></h5>
								@endif
						</div>
					</div>

				</div>
			</div>

		</div>

		<div class="card-footer">
			@form_buttons(['routeCancel' => route('usuarios.index'),'submitName' => 'Atualizar'])
			@endform_buttons
		</div>
		
	</div>

{{ Form::close() }}

@endsection