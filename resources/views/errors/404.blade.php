@extends('layouts.error')

@push('css')
  <link rel="stylesheet" href="{{ URL::asset('css/errors/error_404.css') }}">
@endpush

@section('title')
  <i class="fas fa-exclamation-triangle"></i> Oops! Página não encontrada.
@endsection

@section('content')

  <h1>Erro <span class="errorcode">404</span></h1>
  <p class="output">A página pode ter mudado de nome ou nunca ter existido.</p>
  <p class="output">Tente voltar para a página anterior <a href="{{ url()->previous() }}">nesse link</a> ou acesse a <a href="{{ route('default') }}">página inicial</a></p>
  <p class="output">Boa sorte!!</p>

@endsection
