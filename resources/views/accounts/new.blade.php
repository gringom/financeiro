@extends('layouts.app')

@section('title')
Nova Conta
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h1>Nova Conta</h1>

		<form method="POST" action="/contas/criar">
			{{ csrf_field() }}

			<div class="form-group">
				<input type="text" name="title" class="form-control" placeholder="Nome da conta">
			</div>
			<div class="form-group">
				<textarea name="description" class="form-control" placeholder="Descrição livre sobre a conta"></textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/contas" class="btn btn-default">Voltar</a>
			</div>
		</form>
	</div>
</div>
@stop