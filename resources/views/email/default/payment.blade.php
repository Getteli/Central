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
				<p>Olá {{ $nomeCliente }}, estamos passando para informar que o seu <b>plano</b></p>
				<?php
				switch ($status) {
					case 1:
						echo "<p>
						<b>FOI PAGO</b>
						<p>Já pode aproveitar o nosso serviço e qualquer dúvida é só chamar !</p>
						</p>";
						break;
					case 2:
						echo "<p>
						<b>FOI RECUSADO</b>
						<p>Entre em contato conosco urgentemente pelos nossos meios de contato.</p>
						</p>";
						break;
					default:
						# code...
						break;
				}
				?>
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
				<p><b>Data da confirmação do pagamento:</b>: R$ {{ $date }}</p>
			</div>
			<div class="col l12 m12 s12 center">
				<hr/>
				<p>Algum dado está errado? entre em contato conosco !</p>
			</div>
		</div>
	</main>
</body>