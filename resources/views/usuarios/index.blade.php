@extends('layouts.app')

@push('css')
	<link rel="stylesheet" href="{{ URL::asset('components/datatables/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('js')
	<script src="{{ URL::asset('components/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('components/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ URL::asset('js/datatables-plugins/cache/pipelining.js') }}"></script>
	<script src="{{ URL::asset('components/jquery-dateFormat/jquery-dateformat.min.js') }}"></script>
@endpush

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
@modal_confirm()
@endmodal_confirm

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
						render: function(data,type,full,meta){
							var url_edit = `{!! route('usuarios.index') !!}/${data}/edit`;
							var form_action = `{!! route('usuarios.index') !!}/${data}`;
							var form_name = `deluser-${data}`;
							return dataTablesFormDestroy(url_edit,form_name,form_action);
						}
					}
				]
			});
			
			{{-- 'Componente de ação do modal: views/components/js/modal_confirm_action' --}}
			@modal_confirm_action()
			@endmodal_confirm_action

		});

	</script>
@endpush