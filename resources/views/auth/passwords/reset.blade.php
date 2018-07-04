@extends('layouts.auth')

@section('content')

<p class="login-box-msg">Resetar senha</p>

{{ Form::open(['route' => 'password.request']) }}
	{{ Form::hidden('token',$token) }}
	{{ Form::bsEmail('email','Email',( $email ?? old('email') ),null,['required' => true, 'autofocus' => true]) }}
	{{ Form::bsPassword('password','Senha',null,['required' => true]) }}
	{{ Form::bsPassword('password_confirmation','Confirmar Senha',null,['required' => true]) }}
	<button type="submit" class="btn btn-primary">
		<i class="fas fa-key"></i> Resetar senha
	</button>
{{ Form::close() }}

@endsection
