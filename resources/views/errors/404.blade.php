@extends('layouts.app')

@section('title')
  <i class="fas fa-exclamation-triangle text-warning"></i> Oops! Página não encontrada.
@endsection

@section('content')

<div class="error-page">
  <h2 class="headline text-warning"> 404</h2>

  <div class="error-content">
    <p>
      A página procurada não pode ser encontrada, você pode <a href="{{ route('default') }}">retornar para a página do painel</a>.
    </p>

    @if (env('APP_DEBUG') === true)
      <p>{{ $exception->getMessage() }}</p>
    @endif

  </div>

  

</div>

@endsection