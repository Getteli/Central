<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Serviços - Central')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>listagem de serviços</h1>
            </div>
            <div class="row">
			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Ação</th>
					</tr>
				</thead>
				<tbody>
				@foreach($servicos as $servico)
					<tr>
						<td>{{ $servico->idServico }}</td>
						<td>{{ $servico->servico }}</td>
						<td>
                            <a class="btn blue"
                            href="{{ route('servico.editar',[$servico->idServico]) }}">
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