<!DOCTYPE html>
<html>
<head>
	<!-- Styles -->
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/dashb.css') }}">
</head>
<body>
    <h1>Pagouu</h1>
    <!-- para acessar a variavel -->
    <p>codigo do cliente: {{ $codCliente }}</p>
    <p>email: {{ $entidadeEmail }}</p>
</body>