<!DOCTYPE html>
<html>
<head>
	<!-- Styles -->
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/dashb.css') }}">
</head>
<body>
	<h2><b>Erro ao</b> {{ $TipoError }}</h2>
	<p><b>Ocorreu em</b>: {{ $MethodTarget }}</p>
	<p><b>Quando</b>: {{ $DateError }}</p>
	<p><b>Erro</b>: {{ $MessageError }}</p>