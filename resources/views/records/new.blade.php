@extends('layouts.app')

@section('title')
Novo registro no Banco de Dados
@stop

@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">

		@include('parts.errors')

		<h1>Novo registro no Banco de Dados</h1>

		{!! Form::open(array('url' => '/bd/criar')) !!}
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/bd" class="btn btn-default">Voltar</a>
			</div>
			<div class="form-group">
				{{ Form::label('type', 'Tipo') }}
				{!! Form::select('type', $records['types'], old('type'), ['placeholder' => 'Selecionar Tipo...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('account_id', 'Conta') }}
				{!! Form::select('account_id', $records['accounts'], old('account_id'), ['placeholder' => 'Selecionar Conta...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('category_id', 'Categoria') }}
				<select name="category_id" id="category_id" class="form-control" disabled>
					<option>Selecionar tipo primeiro...</option>
				</select>
			</div>
			<div class="form-group">
				{{ Form::label('person_id', 'Cliente/Fornecedor') }}
				{!! Form::select('person_id', $records['people'], old('person_id'), ['placeholder' => 'Selecionar Cliente/Fornecedor...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('project_id', 'Projeto') }}
				{!! Form::select('project_id', $records['projects'], old('project_id'), ['placeholder' => 'Selecionar Projeto...', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('value', 'Valor (sem o R$)') }}
				{!! Form::input('text', 'value', old('value'), ['placeholder' => 'Informar valor (sem o R$)', 'class' => 'form-control', 'id' => 'maskMoney']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('payment_date', 'Data do Vencimento') }}
				{!! Form::input('text', 'payment_date', old('payment_date'), ['placeholder' => 'Informar a Data do Vencimento (dd/mm/aaaa)', 'class' => 'form-control payment_date']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('paid_date', 'Data do Pagamento') }}
				{!! Form::input('text', 'paid_date', old('paid_date'), ['placeholder' => 'Informar a Data do Pagamento (dd/mm/aaaa)', 'class' => 'form-control paid_date']) !!}
			</div>
			<div class="form-group">
				{{ Form::label('description', 'Descrição') }}
				{!! Form::textarea('description', old('description'), array('class' => 'form-control', 'placeholder' => 'Descrição livre sobre o registro')) !!}
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Gravar</button>
				<a href="/bd" class="btn btn-default">Voltar</a>
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
