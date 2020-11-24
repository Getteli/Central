<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Despesas - Central')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<h1>Despesas</h1>
		</div>
		<div class="row">
			<div class="col s12">
				<a href="{{route('despesa.adicionar')}}">
				<button class="btn blue">Adicionar uma nova despesa</button>
				</a>
			</div>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('despesa.filter') }}">
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
			<p>total: {{ $despesas->count() }}</p>
			<table>
				<thead>
					<tr>
						<th>descrição</th>
						<th>Preço</th>
            <th>Pago em</th>
					</tr>
				</thead>
				<tbody>
				@foreach($despesas as $despesa)
					<tr>
						<td>{{ $despesa->descricao }}</td>
						<td>{{ "R$ ". number_format($despesa->valor, 2) }}</td>
            <td>{{ $despesa->dataPagamento }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			@if(Session::has('resultado'))
				<div>
					{{ Session::get('resultado')['msg'] }}
				</div>
			@endif
			<p>O Total de despesas é: <b>{{ "R$ ". number_format($valorTotal, 2) }}</b></p>
		</div>
	</div>
@endsection
