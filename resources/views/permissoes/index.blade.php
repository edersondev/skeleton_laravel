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
	<i class="fa fa-key"></i> Lista de permissões
@endsection

@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<div class="float-right">
					<a href="{{ route('usuarios.index') }}" class="btn btn-primary"><i class="fa fa-users"></i> Usuários</a>
					<a href="{{ route('perfis.index') }}" class="btn btn-primary"><i class="fas fa-user-lock"></i> Perfis</a></h1>
				</div>
			</div>
			<div class="card-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="permissao-table" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Permissão</th>
								<th>Data de cadastro</th>
								<th>Ações</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="card-footer">
				<a href="{{ route('permissoes.create') }}" class="btn btn-success">
					<i class="fas fa-plus-circle"></i> Adicionar Permissão
				</a>
			</div>
		</div>
	</div>
</div>

{{-- Componente de Modal: views/components/bootstrap/modal_confirm --}}
{{ Form::open(['route' => 'permissoes.index','id'=>'deletar','method'=>'DELETE']) }}
	@modal_confirm(['modal_id' => 'permissao_delete'])
		{{ trans('messages.confirm_destroy') }}
	@endmodal_confirm
{{ Form::close() }}

@endsection

@push('js')
	<script>
		$(function(){
			@component('components.datatable.defaults')
				{!! route('permissoes.jsonlista') !!}
			@endcomponent

			var permissaoTable = $('#permissao-table').DataTable({
				columns: [
					{data: 'co_seq_permissao',visible:false},
					{data: 'ds_nome'},
					{
						data: 'dt_inclusao',
						render: function(data,type,full,meta){
							return $.format.date(data, "dd/MM/yyyy HH:mm");
						}
					},
					{
						data: 'co_seq_permissao',
						width: '15%',
						seachable: false,
						orderable: false,
						render: function(data,type,full,meta){
							return `
								<a class="btn btn-primary btn-sm" href="{!! route('permissoes.index') !!}/${data}/edit" role="button">
									<i class="fas fa-edit"></i> Editar
								</a>
								<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#permissao_delete" data-row="${data}">
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