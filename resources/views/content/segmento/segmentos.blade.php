<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Segmentos - Central')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>listagem de segmentos</h1>
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
				@foreach($segmentos as $segmento)
					<tr>
						<td>{{ $segmento->idSegmento }}</td>
						<td>{{ $segmento->segmento }}</td>
						<td>
                            <a class="btn blue"
                            href="{{ route('segmento.editar',[$segmento->idSegmento]) }}">
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