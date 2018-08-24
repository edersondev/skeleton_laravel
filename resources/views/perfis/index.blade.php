@extends('layouts.app')

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
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Role</th>
								<th>Permissions</th>
								<th>Operation</th>
							</tr>
						</thead>
			
						<tbody>
							@foreach ($roles as $role)
							<tr>
			
								<td>{{ $role->ds_nome }}</td>
			
								<td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('ds_nome')) }}</td>
								<td>
								<a href="{{ route('perfis.edit',$role->co_seq_perfil) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
			
								{!! Form::open(['method' => 'DELETE', 'route' => ['perfis.destroy', $role->co_seq_perfil] ]) !!}
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
				<a href="{{ route('perfis.create') }}" class="btn btn-success">
					<i class="fas fa-plus-circle"></i> Adicionar Perfil
				</a>
			</div>
		</div>
	</div>
</div>

@endsection