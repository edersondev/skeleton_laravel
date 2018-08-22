@extends('layouts.auth')

@section('content')

<p class="login-box-msg">Cadastro</p>

{{ Form::open(['route' => 'register']) }}
	{{ Form::bsText('ds_nome','Nome',null,null,['required' => true,'autofocus' => true]) }}
	{{ Form::bsEmail('email','Email',null,null,['required' => true]) }}
	{{ Form::bsPassword('password','Senha',null,['required' => true]) }}
	{{ Form::bsPassword('password_confirmation','Confirmar Senha',null,['required' => true]) }}

	<button type="submit" class="btn btn-primary">
		<i class="fas fa-user"></i> Registrar
	</button>

{{ Form::close() }}


@endsection
