@extends('layouts.app')

@section('title')
Contas de Usuários
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.flash')

		<h1>Todos os Usuários</h1>

		<ul class="list-group">
			@foreach ($users as $user)
			<?
				$role_name = isset( $user->roles->first()->display_name ) ? $user->roles->first()->display_name : "Sem acesso";
			?>
				<li class="list-group-item">
					<div class="pull-right">
						<a class="btn btn-default" href="/usuarios/{{ $user->id }}">Editar</a>
					</div>
					({{ $user->id }}). {{ $user->name }} ({{ $role_name }})
					<span id="helpBlock" class="help-block">
						{{ $user->email }} 
					</span>
				</li>
			@endforeach
		</ul>
	</div>
</div>
@stop