@extends('layouts.app')

@component('components/datatable/assets')
@endcomponent

@section('title')
	<i class="fa fa-users"></i> Lista de Usuários
@endsection

@section('content')

<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<div class="float-right">
					<a href="{{ route('perfis.index') }}" class="btn btn-primary"><i class="fas fa-user-lock"></i> Perfis</a>
					<a href="{{ route('permissoes.index') }}" class="btn btn-primary"><i class="fas fa-user-tag"></i> Permissões</a>
				</div>
			</div>
			<div class="card-body">

				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="users-table" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nome</th>
								<th>Email</th>
								<th>Data de cadastro</th>
								<th>Usuário ativo?</th>
								<th>Ações</th>
							</tr>
						</thead>
					</table>
				</div>

			</div>
			<div class="card-footer">
				<a href="{{ route('usuarios.create') }}" class="btn btn-success">
					<i class="fas fa-user-plus"></i> Adicionar usuário
				</a>
			</div>
		</div>

	</div>
</div>

{{-- Componente de Modal: views/components/bootstrap/modal_confirm --}}
{{ Form::open(['route' => 'usuarios.index','id'=>'deletar','method'=>'DELETE']) }}
	@modal_confirm(['modal_id' => 'confirmar_deletar'])
		{{ trans('messages.confirm_destroy') }}
	@endmodal_confirm
{{ Form::close() }}

@endsection

@push('js')
	<script>

		$(function() {

			@component('components.datatable.defaults')
				{!! route('usuarios.jsonlista') !!}
			@endcomponent

			var usersTable = $('#users-table').DataTable({
				columns: [
					{data: 'co_seq_usuario',visible:false},
					{data: 'ds_nome'},
					{data: 'email'},
					{
						data: 'dt_inclusao',
						render: function(data,type,full,meta){
							return $.format.date(data, "dd/MM/yyyy HH:mm");
						}
					},
					{
						data: 'st_ativo',
						render: function(data,type,full,meta){
							if(data === false){
								return `<span class="badge badge-danger">Não</span>`;
							}
							return `<span class="badge badge-success">Sim</span>`;
						}
					},
					{
						data: 'co_seq_usuario',
						width: '15%',
						searchable: false,
						orderable: false,
						render: function(data,type,full,meta){
							return `
								<a class="btn btn-primary btn-sm" href="{!! route('usuarios.index') !!}/${data}/edit" role="button">
									<i class="fas fa-edit"></i> Editar
								</a>
								<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmar_deletar" data-row="${data}">
									<i class="fas fa-trash-alt"></i> Deletar
								</button>
							`;
							}
						}
					]
				});
		});
  
	</script>
@endpush