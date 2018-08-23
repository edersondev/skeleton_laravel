@extends('layouts.app')

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
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Permissions</th>
								<th>Operation</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($permissions as $permission)
							<tr>
								<td>{{ $permission->ds_nome }}</td> 
								<td>
								
								{!! Form::open(['method' => 'DELETE', 'route' => ['permissoes.destroy', $permission->co_seq_permissao] ]) !!}
									<a href="{{ route('permissoes.edit',$permission->co_seq_permissao) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Editar</a>
									{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
								{!! Form::close() !!}
			
								</td>
							</tr>
							@endforeach
						</tbody>
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

@endsection