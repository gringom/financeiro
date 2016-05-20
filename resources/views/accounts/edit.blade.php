@extends('layouts.app')

@section('title')
Conta: {{ $account->title }}
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h1>Conta: {{ $account->title }}</h1>
		
		<form method="POST" action="/contas/{{ $account->id }}">
			{{ method_field('PATCH') }}
			{{ csrf_field() }}

			<div class="form-group">
				
			</div>
			<div class="form-group">
				<input type="text" name="title" value="{{ $account->title }}" placeholder="Nome da conta" class="form-control">
			</div>
			<div class="form-group">
				<textarea name="description" class="form-control" placeholder="Descrição livre sobre a conta">{{ $account->description }}</textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/contas" class="btn btn-default">Voltar</a>
				<a href="/contas/{{ $account->id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Conforma a remoção dessa conta?');">Remover</a>
			</div>
		</form>
	</div>
</div>
@stop