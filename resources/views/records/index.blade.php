<?php

$type = isset( $records['form_request']['type'] ) ? $records['form_request']['type'] : old('type');
$account = isset( $records['form_request']['account'] ) ? $records['form_request']['account'] : old('account');
$category = isset( $records['form_request']['category'] ) ? $records['form_request']['category'] : old('category');
$person = isset( $records['form_request']['person'] ) ? $records['form_request']['person'] : old('person');
$project = isset( $records['form_request']['project'] ) ? $records['form_request']['project'] : old('project');
$value = isset( $records['form_request']['value'] ) ? $records['form_request']['value'] : old('value');
$min_value_limit = isset($records['form_request']['min_value_limit']) ? $records['form_request']['min_value_limit'] : 0;
$max_value_limit = isset($records['form_request']['max_value_limit']) ? $records['form_request']['max_value_limit'] : 100000;
$min_selected_value = isset($records['form_request']['min_selected_value']) ? $records['form_request']['min_selected_value'] : $min_value_limit;
$max_selected_value = isset($records['form_request']['max_selected_value']) ? $records['form_request']['max_selected_value'] : $max_value_limit;
$exp_date = isset($records['form_request']['exp_date']) ? $records['form_request']['exp_date'] : null ;
$start_date = isset( $records['form_request']['exp_date_start'] ) ? $records['form_request']['exp_date_start'] : date('d/m/Y', mktime (0, 0, 0, date("m")-1, date("d"),  date("Y")));
$end_date = isset( $records['form_request']['exp_date_end'] ) ? $records['form_request']['exp_date_end'] : date('d/m/Y', mktime (0, 0, 0, date("m"), date("d"),  date("Y")));
$paid_date = isset($records['form_request']['paid_date']) ? $records['form_request']['paid_date'] : null ;

$sum_entrada = $sum_saida = $sum_a_pagar = $sum_a_receber = 0;	
?>

@extends('layouts.app')

@section('title')
Banco de Dados
@stop

@section('head')
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/7.1.0/css/bootstrap-slider.min.css">
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">

		@include('parts.flash')

		<h1>Banco de Dados</h1>

		<a href="/bd/criar" class="btn btn-primary margin-bottom-20">Novo</a>
		{!! Form::open(array('method' => 'GET', 'url' => '/bd/')) !!}
		<div class="table-responsive">
			<table class="table table-striped table-hover">
					<thead>
						<tr style="height: 60px;">
							<th>{!! Form::select('type', $records['types'], $type, ['placeholder' => 'Tipo...', 'class' => 'form-control', 'id' => 'type']) !!}</th>
							<th>{!! Form::select('account', $records['accounts'], $account, ['placeholder' => 'Conta...', 'class' => 'form-control', 'id' => 'account']) !!}</th>
							<th>{!! Form::select('category', $records['categories'], $category, ['placeholder' => 'Categoria...', 'class' => 'form-control', 'id' => 'category']) !!}</th>
							<th>{!! Form::select('person', $records['people'], $person, ['placeholder' => 'Cliente/Fornecedor...', 'class' => 'form-control', 'id' => 'person']) !!}</th>
							<th>{!! Form::select('project', $records['projects'], $project, ['placeholder' => 'Projeto...', 'class' => 'form-control', 'id' => 'project']) !!}</th>
							<th>{!! Form::label('value', 'Valor'); !!}<input id="value_range" name="value" type="text" class="form-control span2" value="" data-slider-min="<?=$min_value_limit?>" data-slider-max="<?=$max_value_limit?>" data-slider-step="50" data-slider-value="[<?=$min_selected_value?>,<?=$max_selected_value?>]"/>
							</th>
							<th>{!! Form::input('text', 'data_venc', $exp_date, ['placeholder' => 'Data do Venc.', 'id' => 'data_venc', 'class' => 'form-control datepicker', 'style' => 'border:0;', 'readonly']) !!}</th>
							<th>{!! Form::input('text', 'data_pag', $paid_date, ['placeholder' => 'Data de Pag.', 'id' => 'data_pag', 'class' => 'form-control datepicker', 'style' => 'border:0;', 'readonly']) !!}</th>
							<th>Descrição</th>
							<th>
								<button type="submit" name="s" class="btn btn-primary pull-right">Pesquisar</button>
								<a class="btn btn-default pull-right margin-right-10" href="/bd">Limpar</a>
							</th>
						</tr>
					</thead>
				@foreach ($records['all'] as $record)
					<?php
					switch ($record->type) {
						case "entrada":
							$sum_entrada += $record->value;
							break;
						case "saida":
							$sum_saida += $record->value;
							break;
						case "a_receber":
							$sum_a_receber += $record->value;
							break;
						case "a_pagar":
							$sum_a_pagar += $record->value;
							break;
					}

					$payment_date = DateTime::createFromFormat('Y-m-d', $record->payment_date);
					$paid_date = isset( $record->paid_date ) ? DateTime::createFromFormat('Y-m-d', $record->paid_date) : "";

					?>
					@if( $record->type == 'a_receber' )
					<tr class="success">
					@elseif( $record->type == 'a_pagar' )
					<tr class="danger">
					@else
					<tr>
					@endif
						<td style="white-space:nowrap;">{{ $records['types'][$record->type] }}</td>
						<td title="{{ $record->account->description }}">{{ $record->account->title }}</td>
						<td title="{{ $record->category->description }}">{{ $record->category->title }}</td>
						<td style="white-space:nowrap;" title="{{ $record->person->description }}">{{ $record->person->title }}</td>
						@if( ! empty($record->project) )
						<td title="{{ $record->project->description }}">{{ $record->project->title }} ({{ $record->project->year }})</td>
						@else
						<td>-</td>
						@endif
						<td>R${{ number_format( $record->value, 2, ",", "." ) }}</td>
						<td>{{ $payment_date->format('d/m/Y') }}</td>
						@if( ! empty($paid_date) )
						<td>{{ $paid_date->format('d/m/Y') }}</td>
						@else
						<td>-</td>
						@endif
						@if( ! empty($record->description) )
						<td style="max-width: 180px;">{{ $record->description }}</td>
						@else
						<td>-</td>
						@endif						
						<td style="white-space:nowrap;">
							<a class="btn btn-info pull-right" href="/bd/{{ $record->id }}/duplicar" onclick="return confirm('Confirma a dupicação desse registro do Banco de Dados?');">Duplicar</a>
							<a class="btn btn-default pull-right margin-right-10" href="/bd/{{ $record->id }}">Editar</a>
						</td>
					</tr>
				@endforeach
			</table>
		</div>
		{!! Form::close() !!}
		<?php
			$sum_values = ($sum_entrada + $sum_a_receber) - ($sum_saida + $sum_a_pagar);
		?>
		<div>
			<p><b>Somatória (A Receber)</b>
			<span class="primary-text">R$ {{ number_format( $sum_a_receber, 2, ",", "." ) }}</span></p>
			<p><b>Somatória (A Pagar)</b>
			<span class="danger-text">R$ {{ number_format( $sum_a_pagar, 2, ",", "." ) }}</span></p>
			<p><b>Somatória (Entrada)</b>
			<span class="primary-text">R$ {{ number_format( $sum_entrada, 2, ",", "." ) }}</span></p>
			<p><b>Somatória (Saída)</b>
			<span class="danger-text">R$ {{ number_format( $sum_saida, 2, ",", "." ) }}</span></p>
			<p><b>Somatória (Entrada + A Receber)</b>
			<span class="primary-text">R$ {{ number_format( $sum_entrada + $sum_a_receber, 2, ",", "." ) }}</span></p>
			<p><b>Somatória (Saída + A Pagar)</b>
			<span class="danger-text">R$ {{ number_format( $sum_saida + $sum_a_pagar, 2, ",", "." ) }}</span></p>
			<p><b>Resultado Final (Entradas - Saídas)</b>
			<span class="<? echo $sum_values > 0 ? 'primary-text' : 'danger-text' ?>">R$ {{ number_format( $sum_values, 2, ",", "." ) }}</span></p>
		</div>
		<a href="/bd/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/7.1.0/bootstrap-slider.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>

@include('parts.filters_value_range')
@include('parts.filters_datepicker')
@stop