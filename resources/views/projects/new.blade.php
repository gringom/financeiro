@extends('layouts.app')

@section('title')
Novo Projeto
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.errors')

		<h1>Novo Projeto</h1>

		{!! Form::open(array('url' => '/projetos/criar')) !!}
			<div class="form-group">
				{!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Nome do projeto')) !!}
			</div>
			<div class="form-group">
				{{ Form::selectYear('year', date('Y')-1, date('Y')+1, old('year'), ['placeholder' => 'Selecionar ano de execução do projeto...', 'class' => 'form-control']) }}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre o projeto')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/projetos" class="btn btn-default">Voltar</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop