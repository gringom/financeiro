@extends('layouts.app')

@section('title')
Clientes e Fornecedores
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@if (Session::has('flash_message'))
			<div class="message-box bg-{{ Session::get('flash_message_level') }}">{{ Session::get('flash_message') }}</div>
		@endif
		<h1>Todas os Clientes e Fornecedores</h1>

		<a href="/clientes_fornecedores/criar" class="btn btn-primary margin-bottom-20">Novo</a>
		<ul class="list-group">
			@foreach ($people as $person)
				<li class="list-group-item">
					<div class="pull-right">
						<a class="btn" href="/clientes_fornecedores/{{ $person->id }}">Editar</a>
					</div>
					{{ $person->title }}
					<span id="helpBlock" class="help-block">
						{{ $person->description }} 
					</span>
				</li>
			@endforeach
		</ul>
		<a href="/clientes_fornecedores/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop