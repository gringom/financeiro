@extends('layouts.app')

@section('title')
Nova Categoria
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h1>Nova Categoria</h1>
		
		{!! Form::open(array('url' => '/categorias/criar')) !!}
			<div class="form-group">
				{!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Nome da categoria')) !!}
			</div>
			<div class="form-group">
				{!! Form::select('type', array('entrada' => 'Entrada', 'saida' => 'Saída'), null, ['placeholder' => 'Selecionar tipo de categoria...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', null, array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre a categoria')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/categorias" class="btn btn-default">Voltar</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop