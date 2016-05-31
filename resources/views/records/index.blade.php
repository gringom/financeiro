@extends('layouts.app')

@section('title')
Banco de Dados
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">

		@include('parts.flash')

		<h1>Banco de Dados</h1>

		<a href="/bd/criar" class="btn btn-primary margin-bottom-20">Novo</a>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
					<thead>
						<th>Tipo</th>
						<th>Conta</th>
						<th>Categoria</th>
						<th>Cliente/Fornecedor</th>
						<th>Projeto</th>
						<th>Valor</th>
						<th>Data do Venc.</th>
						<th>Data do Pag.</th>
						<th>Descrição</th>
						<th>Ações</th>
					</thead>
				@foreach ($records['all'] as $record)
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
						<td>{{ $record->payment_date }}</td>
						@if( ! empty($record->paid_date) )
						<td>{{ $record->paid_date }}</td>
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
					<tfoot>
						<tr>
							<th colspan="5">Somatória (A Receber)</th>
							<th class="primary-text">R$ {{ number_format( $records['sum_values']['a_receber'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
						<tr>
							<th colspan="5">Somatória (A Pagar)</th>
							<th class="danger-text">R$ {{ number_format( $records['sum_values']['a_pagar'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
						<tr>
							<th colspan="5">Somatória (Entrada)</th>
							<th class="primary-text">R$ {{ number_format( $records['sum_values']['entrada'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
						<tr>
							<th colspan="5">Somatória (Saída)</th>
							<th class="danger-text">R$ {{ number_format( $records['sum_values']['saida'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
						<tr>
							<th colspan="5">Somatória (Entrada + A Receber)</th>
							<th class="primary-text">R$ {{ number_format( $records['sum_values']['entradas'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
						<tr>
							<th colspan="5">Somatória (Saída + A Pagar)</th>
							<th class="danger-text">R$ {{ number_format( $records['sum_values']['saidas'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
						<tr>
							<th colspan="5">Resultado Final (Entradas - Saídas)</th>
							<th class="<? echo $records['sum_values']['resultado_final'] > 0 ? 'primary-text' : 'danger-text' ?>">R$ {{ number_format( $records['sum_values']['resultado_final'], 2, ",", "." ) }}</th>
							<th colspan="4"></th>
						</tr>
					</tfoot>
			</table>
		</div>
		<a href="/bd/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop