@extends('layouts.app')

@section('title')
Projeto: {{ $project->title }}
@stop

<?php
	$id = $project->id;
	$title = $project->title;
	$year = $project->year;
	$description = $project->description;
?>

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@if ( count($errors) )
			@foreach( $errors->all() as $error )
				<div class="message-box bg-danger">{{ $error }}</div>
			@endforeach
		@endif

		<h1>Projeto: {{ $project->title }}</h1>

		{!! Form::open(array('url' => '/projetos/' . $id)) !!}
			{{ method_field('PATCH') }}
			<div class="form-group">
				{!! Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Nome do projeto')) !!}
			</div>
			<div class="form-group">
				{{ Form::selectYear('year', date('Y')-1, date('Y')+1, $year, ['placeholder' => 'Selecionar ano de execução do projeto...', 'class' => 'form-control']) }}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', $description, array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre o projeto')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/projetos" class="btn btn-default">Voltar</a>
				<a href="/projetos/{{ $project->id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Confirma a remoção desse projeto?');">Remover</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop