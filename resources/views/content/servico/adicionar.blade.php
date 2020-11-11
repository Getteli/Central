<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Novo Serviço')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<div>
				<h1>Novo serviço</h1>
			</div>

			<div class="container">
				<div class="row">
					<form action="{{ route('servico.salvar') }}" method="post">
						{{csrf_field()}}
						@include('content.servico._form')
						<button class="btn blue">Adicionar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection