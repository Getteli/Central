<!DOCTYPE html>
<html>
<head>
	<!-- Styles -->
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/stylemaildefault.css') }}">
</head>
<body>
	<h3>{{ $TitleSMC }}</h3>

	<p><b>Mensagem</b>: <br/>
	{{ $MessageSMC }}</p>

	<b>---</b>
	<br/>

	<p><b>Contato</b>: {{ $ContactSMC }}</p>
	<p><b>Nome</b>: {{ $NameSMC }}</p>
	<p><b>E-mail</b>: {{ $EmailSMC }}</p>