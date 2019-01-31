@extends('layouts.app')

@push('css')
	<link rel="stylesheet" href="{{ URL::asset('components/titatoggle/titatoggle-dist-min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('components/bootstrap4c-chosen/css/component-chosen.min.css') }}">
@endpush

@push('js')
	<script src="{{ URL::asset('components/chosen/chosen.jquery.min.js') }}"></script>
@endpush

@section('title')
	@php
		$icon = ( Route::currentRouteName() === 'usuarios.create' ? 'plus' : 'edit' );
	@endphp
	<i class="fas fa-user-{{ $icon }}"></i> {{ get_action_page(Route::currentRouteName()) }} Usuário
@endsection

@section('content')

@if( Route::currentRouteName() === 'usuarios.create' )
	{{ Form::open(['route' => 'usuarios.store', 'files' => true]) }}
@else
	{{ Form::model($user, ['route' => array('usuarios.update', $user->co_seq_usuario), 'method' => 'PUT', 'files' => true]) }}
@endif

	<div class="card">
		@if(Route::currentRouteName() === 'usuarios.edit')
		<div class="card-header">
			<div class="float-right">
				<button type="button" class="btn btn-danger" id="btn-delete">
					<i class="fas fa-trash-alt"></i> Deletar
				</button>
			</div>
		</div>
		@endif

		<div class="card-body">

			<div class="row">
				<div class="col-md">

						<div class="card">
							<div class="card-header">
								<i class="fas fa-address-card"></i> Dados do usuário
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md">{{ Form::bsText('ds_nome','Nome',null,null,['required'=>true]) }}</div>
									<div class="col-md">{{ Form::bsEmail('email','Email',null,null,['required'=>true]) }}</div>
								</div>
								
								@php
									$helpTextPassword = ( Route::currentRouteName() === 'usuarios.create' ? null : 'Deixe o campo em branco para manter a mesma senha.' );
									$attrPassword = ( Route::currentRouteName() === 'usuarios.create' ? ['required'=>true] : null );
								@endphp
								<div class="row">
									<div class="col-md">{{ Form::bsPassword('password','Senha',$helpTextPassword,$attrPassword) }}</div>
									<div class="col-md">{{ Form::bsPassword('password_confirmation',' Confirmar Senha',null,$attrPassword) }}</div>
								</div>

								@if( Route::currentRouteName() === 'usuarios.edit' && !is_null($user->img_profile) )
									<div class="card mx-auto d-block" style="max-width: 18rem;">
										<img src="{{ Storage::url($user->img_profile) }}" alt="Imagem Perfil" class="card-img-top">
										<div class="card-body text-right">
											<a class="btn btn-danger btn-sm" href="{{ route('usuario.destroyimg',$user->co_seq_usuario) }}" role="button">
												<i class="fas fa-trash-alt"></i>
											</a>
											<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#zoom_image">
												<i class="fas fa-search-plus"></i>
											</button>
										</div>
									</div>
								@endif

								{{ Form::bsFile('img_profile','Imagem do Perfil') }}

								{{ Form::bsSelect('roles','Perfis',$perfis,null,null,['name'=>'roles[]','class'=>'form-control select-chosen','multiple'=>true]) }}
								
								{{ Form::bsTitaCheckbox('st_ativo','Usuário ativo?',1,( isset($user->st_ativo) ? $user->st_ativo : 0 )) }}
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

@if(Route::currentRouteName() === 'usuarios.edit')
{{ Form::open(['route' => ['usuarios.destroy',$user->co_seq_usuario],'id' => 'deletar','method' => 'DELETE']) }}
{{ Form::close() }}
@endif

@if( Route::currentRouteName() === 'usuarios.edit' && !is_null($user->img_profile) )
	@component('components.bootstrap.modal',['title'=>'Zoom','modal_id'=>'zoom_image','size'=>'large'])
			<img src="{{ Storage::url($user->img_profile) }}" alt="Imagem Perfil" class="img-thumbnail mx-auto d-block" />

		@slot('modal_footer')
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				<i class="fa fa-times"></i> Fechar
			</button>
		@endslot
	@endcomponent
@endif

@endsection

@component('components/chosen/default')
@endcomponent

@push('js')
	<script>
		$(function(){
			$('#btn-delete').click(function(){
				$('#deletar').submit();
			});
		});
	</script>
@endpush