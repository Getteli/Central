<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- metas -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- titulo -->
		<title>@yield('title')</title>

		<!-- Scripts -->
		<!-- Icones materilalize -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

		<!-- Styles -->
		<!-- Compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	</head>
	<body>
		<div id="">
			<main class="">
				@yield('content')
			</main>
		</div>

		<!-- @if(isset($errors) && count($errors)>0)
			<div class="text-center mt-4 mb-4 p-2 alert-danger">
				@foreach($errors->all() as $erro)
					{{$erro}}<br>
				@endforeach
			</div>
		@endif -->

		<!-- notification -->
		@if(Session::has('mensagem'))
			<div id="meu-modal" class="modal {{ Session::get('mensagem')['class'] }}">
				<div class="modal-content">
					<h4>{{ Session::get('mensagem')['title'] }}</h4>
					<p>{{ Session::get('mensagem')['msg'] }}</p>
				</div>
				<div class="modal-footer {{ Session::get('mensagem')['class-mc'] }}">
					<a href="#" id="modal-close" class="modal-close white-text" style="">Fechar</a>
				</div>
			</div>
			<div class="sidenav-overlay {{ Session::get('mensagem')['class-so'] }}"></div>
		@endif

		<!-- scripts -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="{{asset('js/dashb.js')}}"></script>