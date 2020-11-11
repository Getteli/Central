<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Segmentos - Central')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<h1>listagem de segmentos</h1>
		</div>
		<div class="row">
			<div class="col s12">
				<a href="{{route('segmento.adicionar')}}">
				<button class="btn blue">Adicionar Segmento</button>
				</a>
			</div>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('segmento.filter') }}">
				<div class="col l3 m4 s4">
					<input type="text" placeholder="texto" name="texto" value="{{ $filtrar['texto'] ?? '' }}"/>
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
		<div class="row">
			<p>total: {{ $segmentos->count() }}</p>
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
						<td>
							<a class="btn red"
							href="{{ route('segmento.deleteSegmento',$segmento->idSegmento) }}">
							Excluir</a>
						</td>
						@if($segmento->ativo)
						<td>
							<a class="btn green"
							href="{{ route('segmento.desativarSegmento',$segmento->idSegmento) }}">
							Desativar</a>
						</td>
						@else
						<td>
							<a class="btn green"
							href="{{ route('segmento.ativarSegmento',$segmento->idSegmento) }}">
							Ativar</a>
						</td>
						@endif
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