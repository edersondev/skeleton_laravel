@extends('layouts.app')

@section('title')
  <i class="fas fa-user-slash text-danger"></i> Acesso Negado
@endsection

@section('content')
    <div class="error-page">
        <h2 class="headline text-danger"> 401</h2>
        
        <div class="error-content">
            <p>
            Você não possui permissão para acessar essa página. <a href="{{ route('default') }}">Clique aqui para acessar o painel</a>.
            </p>

            @if (env('APP_DEBUG') === true)
                <p>{{ $exception->getMessage() }}</p>
            @endif
            
        </div>
    </div>
@endsection