@extends('layouts.app')

<?php
	$record = $records['this'];

	$id = $record->id;
	$type = isset( $record->type ) ? $record->type : old('type');
	$main_type = $record->type ;
	if( $record->type == "a_pagar" ){
		$main_type = "saida";
	}
	elseif ( $record->type == "a_receber" ) {
		$main_type = "entrada";
	}
	$account_id = isset( $record->account_id ) ? $record->account_id : old('account_id');
	$category_id = isset( $record->category_id ) ? $record->category_id : old('category_id');
	$categories = $records['categories'][$main_type] ;
	$person_id = isset( $record->person_id ) ? $record->person_id : old('person_id');
	$project_id = isset( $record->project_id ) ? $record->project_id : old('project_id');
	$value = isset( $record->value ) ? $record->value : old('value');
	$payment_date = isset( $record->payment_date ) ? $record->payment_date : old('payment_date');
	$paid_date = isset( $record->paid_date ) ? $record->paid_date : old('paid_date');
	$description = isset( $record->description ) ? $record->description : old('description');
?>

@section('title')
Registro: {{ $records['types'][$type] }} / {{ $records['people'][$person_id] }}
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		@include('parts.flash')
		@include('parts.errors')

		<h1>Registro: {{ $records['types'][$type] }} / {{ $records['people'][$person_id] }}</h1>
		@if ( isset($records['extra_message']) )
		<h4>Duplicando um registro</h4>
		@endif

		{!! Form::open(array('url' => '/bd/' . $id)) !!}
			{{ method_field('PATCH') }}
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/bd" class="btn btn-default">Voltar</a>
			</div>
			<div class="form-group">
				{{ Form::label('type', 'Tipo') }}
				{!! Form::select('type', $records['types'], $type, ['placeholder' => 'Selecionar Tipo...', 'class' => 'form-control', 'id' => 'type']) !!}

				{{ Form::hidden('old_type', $type, array('id' => 'old_type')) }}
			</div>
			<div class="form-group">
				{{ Form::label('account_id', 'Conta') }}
				{!! Form::select('account_id', $records['accounts'], $account_id, ['placeholder' => 'Selecionar Conta...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('category_id', 'Categoria') }}
				{!! Form::select('category_id', $categories, $category_id, ['placeholder' => 'Selecionar Categorias...', 'class' => 'form-control', 'id' => 'category_id']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('person_id', 'Cliente/Fornecedor') }}
				{!! Form::select('person_id', $records['people'], $person_id, ['placeholder' => 'Selecionar Cliente/Fornecedor...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('project_id', 'Projeto') }}
				{!! Form::select('project_id', $records['projects'], $project_id, ['placeholder' => 'Selecionar Projeto...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('value', 'Valor (sem o R$)') }}
				{!! Form::input('text', 'value', $value, ['placeholder' => 'Informar valor (sem o R$)', 'class' => 'form-control', 'id' => 'maskMoney']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('payment_date', 'Data do Vencimento') }}
				{!! Form::input('text', 'payment_date', $payment_date, ['placeholder' => 'Informar a Data do Vencimento (dd/mm/aaaa)', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('paid_date', 'Data do Pagamento') }}
				{!! Form::input('text', 'paid_date', $paid_date, ['placeholder' => 'Informar a Data do Pagamento (dd/mm/aaaa)', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('description', 'Descrição') }}
				{!! Form::textarea('description', $description, array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre o registro')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/bd" class="btn btn-default">Voltar</a>
				<a href="/bd/{{ $id }}/delete" class="btn btn-danger pull-right margin-bottom-20" onclick="return confirm('Confirma a remoção desse registro do Banco de Dados?');">Remover</a>
			</div>
		{!! Form::close() !!}

	</div>
</div>
@stop

@section('footer')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    @include('parts.records_datepicker')
    @include('parts.records_money')
    @include('parts.records_type')
    @include('parts.records_awesome_select')
@stop
