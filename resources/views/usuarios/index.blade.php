@extends('layouts.app')

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

				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Date/Time Added</th>
								<th>User Roles</th>
								<th>Operations</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
							<tr>
								<td>{{ $user->ds_nome }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->dt_inclusao->format('F d, Y h:ia') }}</td>
								<td>{{  $user->roles()->pluck('ds_nome')->implode(', ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
								<td>
								
								{!! Form::open(['method' => 'DELETE', 'route' => ['usuarios.destroy', $user->co_seq_usuario] ]) !!}
								<a href="{{ route('usuarios.edit', $user->co_seq_usuario) }}" class="btn btn-info" style="margin-right: 3px;">Edit</a>
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
				<a href="{{ route('usuarios.create') }}" class="btn btn-success">
					<i class="fas fa-user-plus"></i> Adicionar usuário
				</a>
			</div>
		</div>

	</div>
</div>

@endsection