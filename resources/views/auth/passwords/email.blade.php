@extends('layouts.auth')

@section('content')

<p class="login-box-msg">Resetar senha</p>
{{ Form::open(['route' => 'password.email','aria-label' => 'Resetar senha']) }}
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-prepend">
        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
      </div>
      <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
      @if ($errors->has('email'))
        <div class="invalid-feedback">
          <strong>{{ $errors->first('email') }}</strong>
        </div>
      @endif
    </div>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary">
      Enviar link para resetar senha <i class="fas fa-location-arrow"></i>
    </button>
  </div>

{{ Form::close() }}
<p class="mb-1">
  <a href="{{ route('login') }}">
    <i class="fas fa-chevron-left"></i> Voltar para tela de autenticação
  </a>
</p>
@endsection
