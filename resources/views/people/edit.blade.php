@extends('layouts.app')

@section('title')
Cliente/Fornecedor: {{ $person->title }}
@stop

<?php
	$id = $person->id;
	$title = $person->title;
	$description = $person->description;
?>

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.errors')

		<h1>Cliente/Fornecedor: {{ $person->title }}</h1>

		{!! Form::open(array('url' => '/clientes_fornecedores/' . $id)) !!}
			{{ method_field('PATCH') }}
			<div class="form-group">
				{!! Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Nome da cliente/fornecedor')) !!}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', $description, array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre o cliente/fornecedor')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/clientes_fornecedores" class="btn btn-default">Voltar</a>
				<a href="/clientes_fornecedores/{{ $person->id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Confirma a remoção desse Cliente/Fornecedor?');">Remover</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop