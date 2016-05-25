@extends('layouts.app')

@section('title')
Projetos
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.flash')

		<h1>Todos os Projetos</h1>

		<a href="/projetos/criar" class="btn btn-primary margin-bottom-20">Novo</a>
		<ul class="list-group">
			@foreach ($projects as $project)
				<li class="list-group-item">
					<div class="pull-right">
						<a class="btn btn-default" href="/projetos/{{ $project->id }}">Editar</a>
					</div>
					{{ $project->title }} ({{ $project->year }})
					<span id="helpBlock" class="help-block">
						{{ $project->description }} 
					</span>
				</li>
			@endforeach
		</ul>
		<a href="/projetos/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop