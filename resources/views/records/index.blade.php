@extends('layouts.app')

@section('title')
Banco de Dados
@stop

@section('content')
<div class="row">
	<div class="col-md-12">

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
						<td>R${{ number_format( $record->value, 2 ) }}</td>
						<td>{{ $record->payment_date }}</td>
						<td>{{ $record->paid_date }}</td>
						<td style="max-width: 180px;">{{ $record->description }}</td>
						<td style="white-space:nowrap;">
							<a class="btn btn-info pull-right" href="/bd/{{ $record->id }}/duplicar" onclick="return confirm('Confirma a dupicação desse registro do Banco de Dados?');">Duplicar</a>
							<a class="btn btn-default pull-right margin-right-10" href="/bd/{{ $record->id }}">Editar</a>
						</td>
					</tr>
				@endforeach
			</table>
		</div>
		<a href="/bd/criar" class="btn btn-primary margin-bottom-20">Novo</a>
	</div>
</div>
@stop