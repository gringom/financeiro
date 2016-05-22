@extends('layouts.app')

@section('title')
Nova Conta
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@if ( count($errors) )
			@foreach( $errors->all() as $error )
				<div class="message-box bg-danger">{{ $error }}</div>
			@endforeach
		@endif

		<h1>Nova Conta</h1>

		{!! Form::open(array('url' => '/contas/criar')) !!}
			<div class="form-group">
				{!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Nome da conta')) !!}
			</div>
			<div class="form-group">
				{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre a conta')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/contas" class="btn btn-default">Voltar</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@stop