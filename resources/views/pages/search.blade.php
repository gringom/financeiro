<?php
$start_date = isset( $records['request']['exp_date_start'] ) ? $records['request']['exp_date_start'] : date('d/m/Y', mktime (0, 0, 0, date("m")-1, date("d"),  date("Y")));
$end_date = isset( $records['request']['exp_date_end'] ) ? $records['request']['exp_date_end'] : date('d/m/Y', mktime (0, 0, 0, date("m"), date("d"),  date("Y")));

$select_date = isset( $records['request']['date_venc'] ) ? $records['request']['date_venc'] : null;
$select_type = isset( $records['request']['type'] ) ? $records['request']['type'] : old('type');
$select_category = isset( $records['request']['categories_id'] ) ? $records['request']['categories_id'] : old('categories_id');
$select_person = isset( $records['request']['people_id'] ) ? $records['request']['people_id'] : old('people_id');
$select_project = isset( $records['request']['project_id'] ) ? $records['request']['project_id'] : old('project_id');

?>

@extends('layouts.app')

@section('title')
Painel Geral
@stop

@section('head')
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">

        @include('parts.flash')

        <h1>Painel Geral</h1>

		{!! Form::open(array('url' => '/busca', 'method' => 'get')) !!}
			<div class="table-responsive">
				<table class="table">
					<tr style="height: 60px;">
						<td>
							{{ Form::label('date_venc', 'Data de Venc.') }}
							{!! Form::input('text', 'date_venc', $select_date, ['id' => 'datepick', 'class' => 'form-control datepicker', 'style' => 'border:0;', 'readonly']) !!}
						</td>
						<td>
							{{ Form::label('type', 'Tipo') }}
							{!! Form::select('type[]', $records['types'], $select_type, ['class' => 'form-control', 'multiple' => true, 'id' => 'type']) !!}
						</td>
						<td>
							{{ Form::label('categories_id', 'Categorias') }}
							{!! Form::select('categories_id[]', array("Entrada" => $records['categories']['entrada'], "Saída" => $records['categories']['saida']), $select_category, ['class' => 'form-control', 'multiple' => true, 'id' => 'category']) !!}
						</td>
						<td>
							{{ Form::label('people_id', 'Clientes/Fornecedores') }}
							{!! Form::select('people_id[]', $records['people'], $select_person, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'person']) !!}
						</td>
						<td>
							{{ Form::label('project_id', 'Projetos') }}
							{!! Form::select('project_id[]', $records['projects'], $select_project, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'project']) !!}
						</td>
						<td>
							<button type="submit" class="btn btn-primary">Filtrar</button>
						</td>
					</tr>
				</table>
			</div>
		{!! Form::close() !!}
		<?
		$total_sum = $line_sum = 0;
		$col_sum = array();
		?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<td></td>
						@foreach( $records['accounts'] as $account )
						<td class="text-uppercase"><strong>{!! $account !!}</strong></td>
						@endforeach
						<td class="text-uppercase"><strong>Totais</strong></td>
					</tr>
				</thead>
				@foreach( $records['all'] as $line_key => $line )
				<tr>
					<td class="text-uppercase"><strong>{!! $records["types"][$line_key] !!}</strong></td>
					@foreach( $line as $key => $value )
					<?php
					$line_sum += $value;
					$col_sum[$key][$line_key] = $value;
					?>
					<td>R$ {!! number_format( $value, 2, ",", "." ) !!}</td>
					@endforeach
					<td><strong>R$ {!! number_format( $line_sum, 2, ",", "." ) !!}</strong></td>
					<?php 
					$line_sum = 0;
					?>
				</tr>
				@endforeach
				<tfoot>
					<tr>
						<td class="text-uppercase info"><strong>Totais</strong></td>
						@foreach( $col_sum as $col )
						<?php
						$entrance = isset( $col['entrada'] ) ? $col['entrada'] : 0;
						$exit = isset( $col['saida'] ) ? $col['saida'] : 0;
						$to_rec = isset( $col['a_receber'] ) ? $col['a_receber'] : 0;
						$to_pay = isset( $col['a_pagar'] ) ? $col['a_pagar'] : 0;
						$sum = ($entrance + $to_rec) - ($exit + $to_pay);
						$total_sum += $sum;
						?>
						<td class="<?= $sum >= 0 ? 'info' : 'danger';?>"><strong>R$ {!! number_format( $sum, 2, ",", "." ) !!}</strong></td>
						@endforeach
						<td class="info"><strong>R$ {!! number_format( $total_sum, 2, ",", "." ) !!}</strong></td>
					</tr>
				</tfoot>
			</table>
		</div>
    </div>
</div>
@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script type="text/javascript">
	$('#type').select2();
	$('#category').select2();
	$('#person').select2();
	$('#project').select2();

	$('.datepicker').daterangepicker({
		"autoUpdateInput": false,
		"ranges": {
			'Hoje': [moment(), moment()],
			'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Últ. 7 dias': [moment().subtract(6, 'days'), moment()],
			'Últ. 30 dias': [moment().subtract(29, 'days'), moment()],
			'Esse mês': [moment().startOf('month'), moment().endOf('month')],
			'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
	    "locale": {
	        "format": "DD/MM/YYYY",
	        "separator": " - ",
	        "applyLabel": "Aplicar",
	        "cancelLabel": "Limpar",
	        "customRangeLabel": "Personalizar",
	        "daysOfWeek": ["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],
	        "monthNames": ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"]
	    },
	    "startDate": <?=$start_date;?>,
	    "endDate": <?=$end_date;?>
	});
	$('#datepick').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
	});
	$('#datepick').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});
</script>

@stop