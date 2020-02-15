<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Clientes - Central')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>listagem de clientes</h1>
            </div>
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