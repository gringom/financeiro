@extends('layouts.app')

@section('title')
Conta de Usuário: {{ $user->name }}
@stop

<?php
	$id = $user->id;
	$name = $user->name;
	$email = $user->email;
	$role_id = isset( $user->roles->first()->id ) ? $user->roles->first()->id : NULL;
?>

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.errors')

		<h1>Conta de Usuário: {{ $user->name }}</h1>

		{!! Form::open(array('url' => '/usuarios/' . $id)) !!}
			{{ method_field('PATCH') }}
			<div class="form-group">
				Nome: {!! $name !!}
			</div>
			<div class="form-group">
				Email: {!! $email !!}
			</div>
			<div class="form-group">
				{{ Form::label('role_id', 'Funçao') }}
				{!! Form::select('role_id', $user['all_roles'], $role_id, ['placeholder' => 'Selecionar Função do Usuário...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/usuarios" class="btn btn-default">Voltar</a>
				<a href="/usuarios/{{ $id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Confirma a remoção dos acessos deste usuário?');">Remover</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop