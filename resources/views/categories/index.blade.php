@extends('layouts.app')

@section('title')
Categorias
@stop

<?php
	$available_types = array('entrada' => 'Entrada', 'saida' => 'Saída') ;
?>

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<h1>Todas as Categorias</h1>

		<a href="/categorias/criar" class="btn btn-primary margin-bottom-20">Novo</a>
		<ul class="list-group">
			@foreach ($categories as $category)
				<?php
					//print_r($available_types);
					$type = $available_types[$category->type] ;
				?>
				<li class="list-group-item">
					<div class="pull-right">
						<a class="btn" href="/categorias/{{ $category->id }}">Editar</a>
					</div>
					{{ $category->title }} ({{ $type }})
					<span id="helpBlock" class="help-block">
						{{ $category->description }} 
					</span>
				</li>
			@endforeach
		</ul>
		<a href="/categorias/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop