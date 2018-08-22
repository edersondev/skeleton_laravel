@extends('layouts.auth')

@section('content')

<p class="login-box-msg">Faça o login para iniciar sua sessão</p>

  {{ Form::open(['route' => 'login','aria-label' => 'Login']) }}

    <div class="form-group">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-envelope"></i></div>
        </div>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
        @if ($errors->has('email'))
          <div class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="form-group">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-key"></i></div>
        </div>
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        @if ($errors->has('password'))
          <div class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </div>
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-8">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="custom-control-label" for="remember">Lembrar-me</label>
        </div>
      </div>
      <div class="col-4">
        <button type="submit" class="btn btn-primary">
          Login <i class="fas fa-sign-in-alt"></i>
        </button>
      </div>
    </div>
  
  {{ Form::close() }}

<div class="social-auth-links text-center mb-3">
  <p>- OU -</p>
</div>

<p class="mb-1">
  <a class="btn btn-link" href="{{ route('password.request') }}">
    Esqueceu sua senha?
  </a>
</p>

<p class="mb-1">
  <a class="btn btn-link" href="{{ route('register') }}">
    Cadastrar
  </a>
</p>

@endsection
