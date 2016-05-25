@extends('layouts.app')

@section('title')
Novo Cliente/Fornecedor
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.errors')

		<h1>Novo Cliente/Fornecedor</h1>

		{!! Form::open(array('url' => '/clientes_fornecedores/criar')) !!}
			<div class="form-group">
				{!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Nome do Cliente/Fornecedor')) !!}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre o Cliente/Fornecedor')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/clientes_fornecedores" class="btn btn-default">Voltar</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop