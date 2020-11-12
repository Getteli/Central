<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Serviços - Central')
<!-- conteudo -->
@section('content')
	<?php
		use App\Servicos\Segmento;
	?>
	<div>
		<div>
			<h1>listagem de serviços</h1>
		</div>
		<div class="row">
			<div class="col s12">
				<a href="{{route('servico.adicionar')}}">
				<button class="btn blue">Adicionar Serviço</button>
				</a>
			</div>
		</div>
		<div class="row">
			<form method="GET" action="{{ route('servico.filter') }}">
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
				<div class="col l3 m4 s4">
					<select name="segmento">
						<option value="" {{ !isset($filtrar['segmento']) ? 'selected' : '' }}>Segmento</option>
						@foreach(Segmento::all() as $Segmento )
						<option value="{{ $Segmento->idSegmento }}" {{isset($filtrar['segmento']) && $filtrar['segmento'] == $Segmento->idSegmento ? 'selected' : '' }}>{{ $Segmento->segmento }}</option>
						@endforeach
					</select>
				</div>
				<button type="submit" class="btn blue">Buscar</button>
			</form>
		</div>
		<div class="row">
			<p>total: {{ $servicos->count() }}</p>
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
						<td>
							<a class="btn red"
							href="{{ route('servico.deleteServico',$servico->idServico) }}">
							Excluir</a>
						</td>
						@if($servico->ativo)
						<td>
							<a class="btn green"
							href="{{ route('servico.desativarServico',$servico->idServico) }}">
							Desativar</a>
						</td>
						@else
						<td>
							<a class="btn green"
							href="{{ route('servico.ativarServico',$servico->idServico) }}">
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
