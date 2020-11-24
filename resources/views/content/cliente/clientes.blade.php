<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Clientes - Central')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<h1>listagem de clientes</h1>
		</div>
		<div class="row">
			<div class="col s12">
				<a href="{{route('cliente.adicionar')}}">
				<button class="btn blue">Adicionar cliente</button>
				</a>
			</div>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('cliente.filter') }}">
				<div class="col l3 m4 s12">
					<input type="text" placeholder="razao social,nome, cnpj, cod. do cliente, email..." name="texto" value="{{ $filtrar['texto'] ?? '' }}"/>
				</div>
				<div class="col l3 m4 s6">
					<select name="status">
						<option value="" {{ !isset($filtrar['status']) ? 'selected' : '' }}>Ativado & Desativado</option>
						<option value="1" {{ isset($filtrar['status']) && $filtrar['status'] == '1' ? 'selected' : '' }}>Ativado</option>
						<option value="0" {{ isset($filtrar['status']) && $filtrar['status'] == '0' ? 'selected' : '' }}>Desativado</option>
					</select>
				</div>
				<button type="submit" class="btn blue btn-pos">Buscar</button>
			</form>
		</div>
		<p>total: {{ $clientes->count() }}</p>
		<div class="row">
			<table>
				<thead>
					<tr>
						<th>Nome / fantasia</th>
						<th>Documento</th>
						<th>Cod. Cliente</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($clientes as $cliente)
					<tr>
						<td>{{ $cliente->razaoSocial ?? $cliente->Entidade->apelido }}</td>
						<td>{{ $cliente->cnpj ?? 'não possui' }}</td>
						<td>{{ $cliente->codCliente }}</td>
						<td>
							<a class="btn blue"
							href="{{ route('cliente.editar',[$cliente->idCliente, $cliente->idEntidade]) }}">
							Editar</a>
							<!-- </td>
							<td> -->
							<a class="btn red"
							href="{{ route('cliente.deleteEntidade',$cliente->idEntidade) }}">
							Excluir</a>
							<!-- </td> -->
							@if($cliente->ativo)
							<!-- <td> -->
							<a class="btn green"
							href="{{ route('cliente.desativarEntidade',$cliente->idEntidade) }}">
							Desativar</a>
							<!-- </td> -->
							@else
							<!-- <td> -->
							<a class="btn green"
							href="{{ route('cliente.ativarEntidade',$cliente->idEntidade) }}">
							Ativar</a>
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
		</div>
	</div>
@endsection
