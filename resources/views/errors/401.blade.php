@extends('layouts.error')

@section('title')
  <i class="fas fa-user-slash text-danger"></i> Acesso Negado
@endsection

@section('content')

	<h1>Erro <span class="errorcode">401</span></h1>
	<p class="output">Você não possui permissão para acessar essa página. <a href="{{ route('default') }}">Clique aqui para acessar o painel</a>.</p>
	@if (env('APP_DEBUG') === true)
		<p>{{ $exception->getMessage() }}</p>
	@endif

@endsection