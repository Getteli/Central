<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Dashboard - Central')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<div>
				<h1>Dashboard</h1>
			</div>

			@if(Session::has('mensagem'))
				<div>
					{{ Session::get('mensagem')['msg'] }}
				</div>
			@endif
		</div>
	</div>
@endsection