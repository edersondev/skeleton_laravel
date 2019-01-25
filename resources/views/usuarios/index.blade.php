@extends('layouts.app')

@component('components/datatable/assets')
@endcomponent

@push('css')
	<link rel="stylesheet" href="{{ URL::asset('components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">
@endpush

@push('js')
	<script src="{{ URL::asset('components/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
	<script src="{{ URL::asset('components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ URL::asset('components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
@endpush

@section('title')
	<i class="fa fa-users"></i> Lista de Usuários
@endsection

@section('content')

<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<a href="{{ route('usuarios.create') }}" class="btn btn-success">
					<i class="fas fa-user-plus"></i> Adicionar usuário
				</a>
				<div class="float-right">
					<a href="{{ route('perfis.index') }}" class="btn btn-primary"><i class="fas fa-user-lock"></i> Perfis</a>
					<a href="{{ route('permissoes.index') }}" class="btn btn-primary"><i class="fas fa-user-tag"></i> Permissões</a>

					<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#search_form">
						<i class="fas fa-search" aria-hidden="true"></i> Pesquisar
					</button>

					<button type="button" class="btn btn-danger" id="btn-delete-rows">
						<i class="fas fa-trash-alt"></i> Deletar
					</button>

				</div>
			</div>
			<div class="card-body">

				{{ Form::open(['route' => 'usuarios.index', 'id' => 'form_search']) }}
				<div class="card card-info card-outline mb-4 collapse" id="search_form">
					<div class="card-header">Pesquisar usuário por:</div>
					<div class="card-body">

						<div class="row">
							<div class="col-md">{{ Form::bsText('ds_nome','Nome') }}</div>
							<div class="col-md">{{ Form::bsEmail('email','Email') }}</div>
							<div class="col-md">{{ Form::bsSelect('st_ativo','Ativo?',[1=>'Sim',2=>'Não'],null,null,['placeholder'=>'Selecione']) }}</div>
							<div class="col-md">{{ Form::bsDatepicker('dt_inclusao','Data de cadastro') }}</div>
							<div class="col-md">{{ Form::bsSelect('co_perfil','Perfil',$arrPerfil,null,null,['placeholder'=>'Selecione']) }}</div>
						</div>
						
					</div>
					<div class="card-footer">
						<button class="btn btn-primary mb-2" type="button" id="btSearch" title="Pesquisar">
							<i class="fa fa-search" aria-hidden="true"></i> Pesquisar
						</button>
						<button type="button" class="btn btn-warning mx-sm-1 mb-2" id="btClear" title="Limpar">
							<i class="fa fa-eraser" aria-hidden="true"></i> Limpar
						</button>
					</div>
				</div>
				{{ Form::close() }}

				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="users-table" width="100%">
						<thead>
							<tr>
								<th></th>
								<th>ID</th>
								<th>Nome</th>
								<th>Email</th>
								<th>Data de cadastro</th>
								<th>Perfil</th>
								<th>Usuário ativo?</th>
							</tr>
						</thead>
					</table>
				</div>

			</div>
		</div>

	</div>
</div>

{{-- Form para deletar registros --}}
{{ Form::open(['route' => 'usuarios.destroy-list','id'=>'form-delete-rows']) }}
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
Você precisa selecionar ao menos um registro.
@endcomponent

@endsection

@component('components.datatable.defaults')
	{!! route('usuarios.jsonlista') !!}
@endcomponent

@push('js')
	<script>

		$(function() {

			$('#dt_inclusao').mask('00/00/0000');
			$('#dt_inclusao').datepicker({
        format: "dd/mm/yyyy",
					clearBtn: true,
					language: "pt-BR",
					autoclose: true,
					todayHighlight: true,
					toggleActive: true
    	});

			var usersTable = $('#users-table').DataTable({
				columns: [
					{
						data: 'co_seq_usuario',
						searchable: false,
						orderable: false,
						class:'text-center',
						width:'4%',
						render: function(data,type,full,meta){
							var element = $('<span>',{'class':'selected-row','title':'Selecionar registro'});
							element.append($('<i>',{'class':'far fa-square'}));
							return element.get(0).outerHTML;
						}
					},
					{data: 'co_seq_usuario',width:"5%"},
					{
						data: 'ds_nome',
						render: function(data,type,full,meta){
							var linkElement = $('<a>',{
								'href':`{!! route('usuarios.index') !!}/${full.co_seq_usuario}/edit`,
								'title':`Editar Registro: ${data}`,
								'text':data
							});
							return linkElement.get(0).outerHTML;
						}
					},
					{data: 'email'},
					{
						data: 'dt_inclusao',
						render: function(data,type,full,meta){
							return $.format.date(data, "dd/MM/yyyy HH:mm");
						}
					},
					{
						data: 'roles',
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
					},
					{
						data: 'st_ativo',
						render: function(data,type,full,meta){
							var element = $('<span>',{'class':'badge badge-success','text':'Sim'});
							if(data === false){
								element.attr('class','badge badge-danger').text('Não');
							}
							return element.get(0).outerHTML;
						}
					}
					]
				});

			$('#users-table tbody').on( 'click', 'tr td span.selected-row', function () {
				$(this).closest('tr').toggleClass('selected');
				var iconClass = ( $(this).closest('tr').hasClass('selected') ? 'far fa-check-square' : 'far fa-square' );
				$(this).children('i').attr('class',iconClass);
			});

			$('#btn-delete-rows').on('click',function(){
				var selectRow = usersTable.rows('.selected').data()
						form = $('#form-delete-rows');
				if(selectRow.length < 1){
					$('#alert-selected').modal('show');
					return false;
				}
				form.find("input[name='co_usuario[]']").remove();
				$.each(selectRow, function( index, value ) {
					form.prepend($('<input>',{'name':'co_usuario[]','type':'hidden','value':value.co_seq_usuario}));
				});
				$('#confirm-delete').modal('show');
			});

			// Form Search
			$('#btSearch').click(function(){
				var formData = $('#form_search').serialize();
				usersTable.search(formData).draw();
			});
			$('#btClear').click(function(){
				usersTable.search('').draw();
				$('#search_form').collapse('hide');
			});

		});
  
	</script>
@endpush