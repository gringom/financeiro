@extends('layouts.app')

@section('title')
Categoria: {{ $category->title }}
@stop

<?php
	$id = $category->id;
	$title = $category->title;
	$type = $category->type;
	$description = $category->description;
?>

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@if ( count($errors) )
			@foreach( $errors->all() as $error )
				<div class="message-box bg-danger">{{ $error }}</div>
			@endforeach
		@endif

		<h1>Categoria: {{ $category->title }}</h1>

		{!! Form::open(array('url' => '/categorias/' . $id)) !!}
			{{ method_field('PATCH') }}
			<div class="form-group">
				{!! Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Nome da categoria')) !!}
			</div>
			<div class="form-group">
				{!! Form::select('type', array('entrada' => 'Entrada', 'saida' => 'Saída'), $type, ['placeholder' => 'Selecionar tipo de categoria...', 'class' => 'form-control', 'required']) !!}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', $description, array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre a categoria')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/categorias" class="btn btn-default">Voltar</a>
				<a href="/categorias/{{ $category->id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Confirma a remoção dessa categoria?');">Remover</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop