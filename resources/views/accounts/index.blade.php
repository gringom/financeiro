@extends('layouts.app')

@section('title')
Contas
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.flash')

		<h1>Todas as Contas</h1>

		<a href="/contas/criar" class="btn btn-primary margin-bottom-20">Novo</a>
		<ul class="list-group">
			@foreach ($accounts as $account)
				<li class="list-group-item">
					<div class="pull-right">
						<a class="btn btn-default" href="/contas/{{ $account->id }}">Editar</a>
					</div>
					{{ $account->title }}
					<span id="helpBlock" class="help-block">
						{{ $account->description }} 
					</span>
				</li>
			@endforeach
		</ul>
		<a href="/contas/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop