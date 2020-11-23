<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Recebidos - Central')
<!-- conteudo -->
@section('content')
	<?php
		use App\Servicos\Segmento;
		use App\Servicos\FormasPagamento;
	?>
	<div>
		<div>
			<h1>Recebidos</h1>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('recebido.filter') }}">
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
			<p>total: {{ $recebidos->count() }}</p>
			<table>
				<thead>
					<tr>
						<th>Entrada</th>
						<th>Serviço</th>
						<th>Preço</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($recebidos as $recebido)
					<tr>
						<td>{{ $recebido->dataEntrada }}</td>
						<td>{{ $recebido->descricao }}</td>
						<td>{{ "R$ ". number_format($recebido->valor, 2) }}</td>
						<td>
							@if(isset($recebido->idPlano))
							  <a class="btn blue"
							  href="{{ route('recebido.verCliente',$recebido->idPlano) }}">
							  Ver o Cliente</a>
							@else
								<p>sem cliente</p>
							@endif
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
			<p>O Total recebido é: <b>{{ "R$ ". number_format($valorTotal, 2) }}</b></p>
		</div>
	</div>
@endsection
