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
	<i class="fa fa-key"></i> Perfis
@endsection
	
@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<div class="float-right">
					<a href="{{ route('usuarios.index') }}" class="btn btn-primary"><i class="fa fa-users"></i> Usuários</a>
					<a href="{{ route('permissoes.index') }}" class="btn btn-primary"><i class="fas fa-user-tag"></i> Permissões</a></h1>
				</div>
			</div>
			<div class="card-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="perfil-table" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Perfil</th>
								<th>Data de cadastro</th>
								<th>Ações</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="card-footer">
				<a href="{{ route('perfis.create') }}" class="btn btn-success">
					<i class="fas fa-plus-circle"></i> Adicionar Perfil
				</a>
			</div>
		</div>
	</div>
</div>

{{-- Componente de Modal: views/components/bootstrap/modal_confirm --}}
@modal_confirm(['modal_id' => 'perfil_delete'])
	{{ trans('messages.confirm_destroy') }}
@endmodal_confirm

@endsection

@push('js')
	<script>
		$(function(){
			@component('components.datatable.defaults')
				{!! route('perfis.jsonlista') !!}
			@endcomponent

			var perfilTable = $('#perfil-table').DataTable({
				columns: [
					{data: 'co_seq_perfil',visible:false},
					{data: 'ds_nome'},
					{
						data: 'dt_inclusao',
						render: function(data,type,full,meta){
							return $.format.date(data, "dd/MM/yyyy HH:mm");
						}
					},
					{
						data: 'co_seq_perfil',
						width: '15%',
						searchable: false,
						orderable: false,
						render: function(data,type,full,meta){
							return `
								<form name="delperfil-${data}" id="delperfil-${data}" action="{!! route('perfis.index') !!}/${data}" method="post">
									{!! csrf_field() !!}
									{!! method_field('DELETE') !!}
									<a class="btn btn-primary btn-sm" href="{!! route('perfis.index') !!}/${data}/edit" role="button">
										<i class="fas fa-edit"></i> Editar
									</a>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#perfil_delete">
										<i class="fas fa-trash-alt"></i> Deletar
									</button>
								</form>
							`;
						}
					}
				]
			});

		});
	</script>
@endpush