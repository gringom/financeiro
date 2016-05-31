@extends('layouts.app')

@section('title')
Tabela Dinâmica
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">

        @include('parts.flash')

        <h1>Tabela Dinâmica</h1>

		{!! Form::open(array('url' => '/busca')) !!}
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Buscar</button>
			</div>
			<div class="form-group">
				{{ Form::label('title', 'Pesquisar em todos os campos') }}
				{!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Pesquisar em todos os campos')) !!}
			</div>
			<div class="form-group">
				{{ Form::label('account_id', 'Selecionar Contas') }}
				{!! Form::select('account_id[]', $records['accounts'], old('account_id'), ['class' => 'form-control', 'multiple' => 'multiple']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('entrance_id', 'Selecionar Categorias de Entrada') }}
				{!! Form::select('entrance_id[]', $records['categories']['entrada'], old('entrance_id'), ['class' => 'form-control', 'multiple' => 'multiple']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('exit_id', 'Selecionar Categorias de Saída') }}
				{!! Form::select('exit_id[]', $records['categories']['saida'], old('exit_id'), ['class' => 'form-control', 'multiple' => 'multiple']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('people_id', 'Selecionar Pessoas') }}
				{!! Form::select('people_id[]', $records['people'], old('people_id'), ['class' => 'form-control', 'multiple' => 'multiple']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('project_id', 'Selecionar Projetos') }}
				{!! Form::select('project_id[]', $records['projects'], old('project_id'), ['class' => 'form-control', 'multiple' => 'multiple']) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Buscar</button>
			</div>
		{!! Form::close() !!}
    </div>
</div>
@endsection
