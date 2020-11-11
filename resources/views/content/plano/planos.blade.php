<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Planos - Central')
<!-- conteudo -->
@section('content')
	<?php
		use App\Segmento;
		use App\Servicos\FormasPagamento;
	?>
	<div>
		<div>
			<h1>Planos</h1>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('plano.filter') }}">
				<div class="col l3 m4 s4">
					<input type="text" placeholder="texto" name="texto" value="{{ $filtrar['texto'] ?? '' }}"/>
				</div>
				<div class="col l3 m4 s4">
					<input type="number" placeholder="até R$ valor" name="preco" min="0" value="{{ $filtrar['preco'] ?? '' }}"/>
				</div>
				<div class="col l3 m4 s4">
					<select name="formaPagamento">
						<option value="" {{ !isset($filtrar['formaPagamento']) ? 'selected' : '' }}>Todas</option>
						@foreach(FormasPagamento::getAll() as $meioPagto => $key )
						<option value="{{ $key }}" {{isset($filtrar['formaPagamento']) && $filtrar['formaPagamento'] == $key ? 'selected' : '' }}>{{ $meioPagto }}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn blue">Buscar</button>
			</form>
		</div>
		<div class="row">
			<p>total: {{ $planos->count() }}</p>
			<table>
				<thead>
					<tr>
						<th>Dia de Pagamento</th>
						<th>Forma</th>
						<th>Descrição</th>
						<th>Preço</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($planos as $plano)
					<tr>
						<td>{{ $plano->dataPagamento }}</td>
						<td>{{ FormasPagamento::getNameFPagamento($plano->formaPagamento) }}</td>
						<td>{{ $plano->descricao }}</td>
						<td>{{ "R$ ". number_format($plano->preco, 2) }}</td>
						<td>
							<a class="btn blue"
							href="{{ route('plano.editar',[$plano->idPlano]) }}">
							Editar</a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			@if(Session::has('resultado'))
				<div>
					{{ Session::get('resultado')['msg'] }}
				</div>
			@endif
			<p>total: <b>{{ "R$ ". number_format($valorTotal, 2) }}</b></p>
		</div>
	</div>
@endsection