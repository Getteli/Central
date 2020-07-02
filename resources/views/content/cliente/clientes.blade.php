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
				<div class="col l3 m4 s4">
					<input type="text" placeholder="razao social,nome, cnpj, cod. do cliente, email..." name="texto" value="{{ $filtrar['texto'] ?? '' }}"/>
				</div>
				<div class="col l3 m4 s4">
					<select name="status">
						<option value="" {{ !isset($filtrar['status']) ? 'selected' : '' }}>Ativado & Desativado</option>
						<option value="1" {{ isset($filtrar['status']) && $filtrar['status'] == '1' ? 'selected' : '' }}>Ativado</option>
						<option value="0" {{ isset($filtrar['status']) && $filtrar['status'] == '0' ? 'selected' : '' }}>Desativado</option>
					</select>
				</div>
				<button type="submit" class="btn blue">Buscar</button>
			</form>
		</div>
		<p>total: {{ $clientes->count() }}</p>
		<div class="row">
			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>ent</th>
						<th>Cnpj</th>
						<th>Razão Social</th>
						<th>Código de Cliente</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($clientes as $cliente)
					<tr>
						<td>{{ $cliente->idCliente }}</td>
						<td>{{ $cliente->idEntidade }}</td>
						<td>{{ $cliente->cnpj }}</td>
						<td>{{ $cliente->razaoSocial }}</td>
						<td>{{ $cliente->codCliente }}</td>
						<td>
							<a class="btn blue"
							href="{{ route('cliente.editar',[$cliente->idCliente, $cliente->idEntidade]) }}">
							Editar</a>
						</td>
						<td>
							<a class="btn red"
							href="{{ route('cliente.deleteEntidade',$cliente->idEntidade) }}">
							Excluir</a>
						</td>
						@if($cliente->ativo)
						<td>
							<a class="btn green"
							href="{{ route('cliente.desativarEntidade',$cliente->idEntidade) }}">
							Desativar</a>
						</td>
						@else
						<td>
							<a class="btn green"
							href="{{ route('cliente.ativarEntidade',$cliente->idEntidade) }}">
							Ativar</a>
						</td>
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>

			@if(Session::has('mensagem'))
				<div>
					{{ Session::get('mensagem')['msg'] }}
				</div>
			@endif
		</div>
	</div>
@endsection