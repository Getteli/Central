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
			<div class="col s12">
				<a href="{{route('recebido.adicionar')}}">
				<button class="btn blue">Recibo Externo</button>
				</a>
			</div>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('recebido.filter') }}">
				<input hidden readonly type="number" name="idp" value="{{ $filtrar['idp'] ?? '' }}"/>
				<div class="col l3 m4 s12">
					<input type="text" placeholder="texto" name="texto" value="{{ $filtrar['texto'] ?? '' }}"/>
				</div>
				<div class="col l3 m4 s6">
					<input type="number" placeholder="até R$ valor" name="preco" min="0" value="{{ $filtrar['preco'] ?? '' }}"/>
				</div>
				<div class="col l3 m4 s12 flex">
					<input type="date" name="dataini" value="{{ $filtrar['dataini'] ?? '' }}"/>
					&nbsp;<p>até</p>&nbsp;
					<input type="date" name="datafim" value="{{ $filtrar['datafim'] ?? date('Y-m-d') }}"/>
				</div>
				<button type="submit" class="btn blue btn-pos">Buscar</button>
			</form>
		</div>
		<div class="row">
			<p>total: {{ $recebidos->count() }}</p>
			<table>
				<thead>
					<tr>
						<th>Entrada</th>
						<th>Serviço / descrição</th>
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
							  Cliente</a>
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
