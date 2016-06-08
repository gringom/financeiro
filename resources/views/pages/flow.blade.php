<?php


?>

@extends('layouts.app')

@section('title')
Fluxo de Caixa
@stop

@section('head')

@stop

@section('content')
<div class="row">
    <div class="col-lg-12">

        @include('parts.flash')

        <h1>Fluxo de Caixa</h1>
<?php
// print_pre( $records['categories'] );
// print_pre( $records['dates'] );
// print_pre( $records['types'] );
// print_pre( $records['request'] );
// print_pre( $records['dates'] );
// print_pre( $records['all'] );
		$sub_total = $results = $totals = array_fill_keys($records['dates'], 0);
		$col = count($records['dates']) + 2;
		$total_result = $last_month_result = 0;
?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<td></td>
						@foreach( $records['textual_dates'] as $d )
						<td class="text-uppercase"><strong>{!! $d !!}</strong></td>
						@endforeach
						<td class="text-uppercase"><strong>Totais</strong></td>
					</tr>
				</thead>
				<tr>
					@foreach( $records['all']['entrada'] as $cat_id => $info )
					<?php $line_sum = 0; ?>
					<td class="text-uppercase"><strong>{!! $records['categories']['entrada'][$cat_id] !!}</strong></td>
					@foreach( $info as $key => $value )
					<?php
					$line_sum += $value;
					$totals[$key] += $value;
					$sub_total[$key] += $value;
					?>
					<td>R$ {!! br_num_format($value, true) !!}</td>
					@endforeach
					<td><strong>R$ {!! br_num_format($line_sum, true) !!}</strong></td>
					@endforeach
				</tr>
				<?php
					$line_sum = 0;
				?>
				<tr class="info">
					<td class="text-uppercase"><strong>totais entrada</strong></td>
					@foreach($sub_total as $key => $value)
					<?php
						$line_sum += $value;
						$class = getSumClass( $value );
					?>
					<td class="<?=$class;?>"><strong>R$ {!! br_num_format($value, true) !!}</strong></td>
					@endforeach
					<?php 
					$total_result = $line_sum;
					?>
					<td><strong>R$ {!! br_num_format($line_sum, true) !!}</strong></td>
				</tr>
				<?php
					$line_sum = 0;
					$sub_total = array_fill_keys($records['dates'], 0);
				?>
				<tr>
					<td colspan="<?=$col;?>"></td>
				</tr>
				<tr>
					@foreach( $records['all']['saida'] as $cat_id => $info )
					<?php $line_sum = 0; ?>
					<td class="text-uppercase"><strong>{!! $records['categories']['saida'][$cat_id] !!}</strong></td>
					@foreach( $info as $key => $value )
					<?php 
					$line_sum += $value;
					$totals[$key] -= $value;
					$sub_total[$key] += $value;
					?>
					<td>R$ {!! br_num_format($value, true) !!}</td>
					@endforeach
					<?php 
					$total_result -= $line_sum;
					?>
					<td><strong>R$ {!! br_num_format($line_sum, true) !!}</strong></td>
					@endforeach
				</tr>
				<?php
					$line_sum = 0;
				?>
				<tr class="danger">
					<td class="text-uppercase"><strong>totais saída</strong></td>
					@foreach($sub_total as $key => $value)
					<?php
						$line_sum += $value;
					?>
					<td><strong>R$ {!! br_num_format($value, true) !!}</strong></td>
					@endforeach
					<td><strong>R$ {!! br_num_format($line_sum, true) !!}</strong></td>
				</tr>
				<tr>
					<td colspan="<?=$col;?>"></td>
				</tr>
				<tfoot>
					<tr>
						<td class="text-uppercase"><strong>Total do mês</strong></td>
						@foreach($totals as $key => $value)
						<?php
							$results[$key] = $last_month_result + $value;
							$last_month_result += $value;
							$class = getSumClass( $value );
						?>
						<td class="<?=$class;?>"><strong>R$ {!! br_num_format($value, true) !!}</strong></td>
						@endforeach
						<td>-</td>
					</tr>
					<tr>
						<td class="text-uppercase"><strong>Resultado</strong></td>
						@foreach($results as $value)
						<?php
							$class = getSumClass( $value );
						?>
						<td class="<?=$class;?>"><strong>R$ {!! br_num_format($value, true) !!}</strong></td>
						@endforeach
						<?php
							$class = getSumClass( $total_result );
						?>
						<td class="<?=$class;?>"><strong>R$ {!! br_num_format($total_result, true) !!}</strong></td>
					</tr>
				</tfoot>
			</table>
		</div>
    </div>
</div>
@endsection

@section('footer')

@stop