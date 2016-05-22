@extends('layouts.app')

@section('title')
Conta: {{ $account->title }}
@stop

<?php
	$id = $account->id;
	$title = $account->title;
	$description = $account->description;
?>

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@if ( count($errors) )
			@foreach( $errors->all() as $error )
				<div class="message-box bg-danger">{{ $error }}</div>
			@endforeach
		@endif

		<h1>Conta: {{ $account->title }}</h1>

		{!! Form::open(array('url' => '/contas/' . $id)) !!}
			{{ method_field('PATCH') }}
			<div class="form-group">
				{!! Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Nome da conta')) !!}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', $description, array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre a conta')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/contas" class="btn btn-default">Voltar</a>
				<a href="/contas/{{ $account->id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Confirma a remoção dessa conta?');">Remover</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop