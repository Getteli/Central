<!DOCTYPE html>
<html>
<head>
	<!-- Styles -->
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/mailp.css') }}">
</head>
<body>
	<main>
		<div class="row"> <!-- bottom-sheet -->
			<div class="col l12 m12 s12 center">
				<h4>Agência Publikando</h4>
				<p>Olá {{ $nomeCliente }}, estamos passando para lhe dar as boas vindas !</p>
				<p>Você foi cadastrado em nosso sistema, agora qualquer problema que você <b>ACHA</b>
				que tem, é nosso problema ;)</p>
				<p>Portanto, entre em contato pelos nossos canais oficiais (email, facebook, instagram ...) caso tenha alguma dúvida, algum problema com os serviços contratados ou qualquer outro.</p>
				<hr/>
			</div>
			<div class="col l12 m12 s12 center">
				<p>Verifique os seus dados:</p>
				<!-- para acessar a variavel -->
				<p><b>E-mail</b>: {{ $entidadeEmail }}</p>
				<p><b>Código do cliente</b>: {{ $codCliente }}</p>
				<p><b>Código da licença</b>: {{ $codLicense }}</p>
				<p><b>Serviço</b>: {{ $servicoPrestado }}</p>
				<p><b>Valor:</b>: R$ {{ $valor }}</p>
				<p><b>Data de pagamento:</b>: Todo o dia {{ $date }}</p>
				<p><b>Forma de pagamento:</b> {{ $formaPag }}</p>
				<?php
				if(isset($obs)){
					echo "<p><b>Observação:</b> ".$obs."</p>";
				}
				?>
			</div>
			<div class="col l12 m12 s12 center">
				<hr/>
				<p>Algum dado está errado? entre em contato conosco !</p>
			</div>
		</div>
	</main>
</body>