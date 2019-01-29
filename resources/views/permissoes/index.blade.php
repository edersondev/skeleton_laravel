@extends('layouts.app')

@component('components/datatable/assets')
@endcomponent

@push('css')
	<link rel="stylesheet" href="{{ URL::asset('components/bootstrap4c-chosen/css/component-chosen.min.css') }}">
@endpush

@push('js')
	<script src="{{ URL::asset('components/chosen/chosen.jquery.min.js') }}"></script>
@endpush

@section('title')
	<i class="fa fa-key"></i> Lista de permissões
@endsection

@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#form_permissao">
					<i class="fas fa-plus-circle"></i> Adicionar Permissão
				</button>
				<div class="float-right">
					<a href="{{ route('usuarios.index') }}" class="btn btn-primary"><i class="fa fa-users"></i> Usuários</a>
					<a href="{{ route('perfis.index') }}" class="btn btn-primary"><i class="fas fa-user-lock"></i> Perfis</a>
					<button type="button" class="btn btn-danger" id="btn-delete-rows">
						<i class="fas fa-trash-alt"></i> Deletar
					</button>
				</div>
			</div>
			<div class="card-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="permissao-table" width="100%">
						<thead>
							<tr>
								<th></th>
								<th>ID</th>
								<th>Permissão</th>
								<th>Data de cadastro</th>
								<th>Perfis</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- Form para cadastro / edição de registros --}}
{{ Form::open(['route' => 'permissoes.store']) }}
	@component('components/bootstrap/modal',['modal_id' => 'form_permissao','size'=>'large'])

		{{ Form::bsText('ds_nome','Nome',null,null,['required'=>true]) }}
		{{ Form::bsSelect('roles','Perfis',$perfis,null,null,['name'=>'roles[]','class'=>'form-control select-chosen','multiple'=>true]) }}

		@slot('modal_footer')
			<button type="button" class="btn btn-danger" data-dismiss="modal">
				<i class="fa fa-times"></i> Cancelar
			</button>
			<button type="submit" class="btn btn-primary confirm-submit">
				<i class="fas fa-save"></i> Salvar
			</button>
		@endslot
	@endcomponent
{{ Form::close() }}

{{-- Form para deletar registros --}}
{{ Form::open(['route' => 'permissoes.destroy-list','id'=>'form-delete-rows']) }}
	@component('components/bootstrap/modal',['modal_id' => 'confirm-delete'])
		{{ trans('messages.confirm_destroy') }}

		@slot('modal_footer')
			<button type="button" class="btn btn-secondary" data-dismiss="modal">
				<i class="fa fa-times"></i> Cancelar
			</button>
			<button type="submit" class="btn btn-primary confirm-submit">
				<i class="fas fa-check"></i> Sim
			</button>
		@endslot

	@endcomponent
{{ Form::close() }}

@component('components/bootstrap/modal',['modal_id' => 'alert-selected'])
	{{ trans('messages.confirm_select') }}
@endcomponent

@endsection

@component('components/chosen/default')
@endcomponent

@component('components.datatable.defaults')
	{!! route('permissoes.jsonlista') !!}
@endcomponent

@push('js')
	<script>
		$(function(){
			
			var permissaoTable = $('#permissao-table').DataTable({
				columns: [
					{data: 'co_seq_permissao'},
					{data: 'co_seq_permissao',width:'5%'},
					{
						data: 'ds_nome',
						render: function(data,type,full,meta){
							var linkElement = $('<a>',{
								'href':`#form_permissao`,
								'title':`Editar Registro: ${data}`,
								'data-toggle':'modal',
								'data-row':full.co_seq_permissao,
								'text':data
							});
							linkElement.prepend($('<i>',{'class':'fas fa-edit icon-spacing'}));
							return linkElement.get(0).outerHTML;
						}
					},
					{
						data: 'dt_inclusao',
						render: function(data,type,full,meta){
							return $.format.date(data, "dd/MM/yyyy HH:mm");
						}
					},
					{
						data:'roles',
						orderable: false,
						render: function(data,type,full,meta){
							if(data.length > 0){
								var ulList = $('<ul>');
								$.each(data,function(index,value){
									ulList.append($('<li>',{'text':value.ds_nome}));
								});
								return ulList.get(0).outerHTML;
							}
							return ``;
						}
					}
				]
			});

			$('#btn-delete-rows').on('click',function(){
				var selectRow = permissaoTable.rows('.selected').data()
						form = $('#form-delete-rows');
				if(selectRow.length < 1){
					$('#alert-selected').modal('show');
					return false;
				}
				form.find("input[name='co_permissao[]']").remove();
				$.each(selectRow, function( index, value ) {
					form.prepend($('<input>',{'name':'co_permissao[]','type':'hidden','value':value.co_seq_permissao}));
				});
				$('#confirm-delete').modal('show');
			});

			$('#form_permissao').on('show.bs.modal', function (e) {
				var button = $(e.relatedTarget)
          row_id = button.attr('data-row'),
          form = $(this).parent('form'),
          action = form.attr('action');
				if(row_id !== undefined){
					form.attr('action',`${action}/${row_id}`);
        	form.prepend(`{{ Form::hidden('_method', 'PUT') }}`);
					$.ajax({
						url: `{{ route('permissoes.index') }}/${row_id}/edit`,
						method: 'get',
						dataType: 'json',
						success: function(json){
							$('#ds_nome').val(json.permissao.ds_nome);
							if(json.perfis.length > 0){
								$('#roles').val(json.perfis).trigger("chosen:updated");
							}
						}
					});
				}
			});

			// Resetando Form Modal
			$('#form_permissao').on('hidden.bs.modal', function (event) {
				var form = $(this).parent('form');
				form.attr('action',`{{ route('permissoes.store') }}`);
				form.find('input[type="hidden"][value="PUT"]').remove();
				$(".select-chosen").val('').trigger("chosen:updated");
				form.trigger("reset");
			});

		});
	</script>
@endpush