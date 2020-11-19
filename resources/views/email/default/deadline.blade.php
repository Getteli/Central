<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- metas -->
		<meta charset="utf-8">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<style>
			body{
				margin: 0; padding: 0;
			}
			*{
				font-family: 'arial', sans-serif;
			}
			.table1{
				border-collapse: collapse;
				background-image: url('{{ asset("assets/bgmail.png") }}');
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
				max-width: 800px;
			}
			.space_top{
				padding: 40px 0 30px 0;
			}
			.space_bottom{
				padding: 30px 30px 30px 30px;
			}
			.logo_top{
				max-width: 300px;
				width: 280px;
			}
			.title, b{
				font-weight: normal;
				color: #ff6400;
			}
			.td{
				text-align: justify;
				text-justify: inter-word;
			}
		</style>
	</head>
	<body>
		<table align="center" border="1" cellpadding="0" cellspacing="0" width="75%" class="table1">
			<!-- topo -->
			<tr>
				<td align="center" class="space_top">
					<a href="https://agenciapublikando.com.br/">
						<img src="{{ asset("assets/lt.png") }}" alt="Agência Publikando" width="300" class="logo_top" height="auto"/>
					</a>
				</td>
			</tr>
			<!-- corpo -->
			<tr>
				<td bgcolor="#ffffff" style="">
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center">
								<h1 class="title">Agência Publikando</h1>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td class="td">
											Olá {{ $nomeCliente }}
										</td>
									</tr>
									<tr>
										<td class="td" style="padding: 20px 0 30px 0;">
											Estamos entrando em contato para informar que o seu <b>plano</b> está a <b style="color: red;">{{ $dias }}</b> dias de entrar em <b style="color: red;">modo de espera</b>. Você ficará <b style="color: red;">sem acesso</b> ao seu serviço (seja ele site, loja ou outros.. e postagens agendadas serão paralizadas). Realize o seu pagamento aqui -> <a href="https://payment.agenciapublikando.com.br/?qq={{ $codLicense }}"><b>REALIZAR PAGAMENTO</b></a>
										</td>
									</tr>
									<tr>
										<td>
										</td>
									</tr>
									<tr>
										<td class="td" style="padding: 20px 0 30px 0;">
											Verifique os seus dados, apenas uma burocracia (caso encontre algum erro, nos avise):<br>
											<!-- para acessar a variavel -->
											<b>E-mail:</b> {{ $entidadeEmail }}<br>
											<b>Código do cliente:</b> {{ $codCliente }}<br>
											<b>Código da licença:</b> {{ $codLicense }}<br>
											<b>Serviço:</b> {{ $servicoPrestado }}<br>
											<b>Valor:</b> <b style="color: green;">R$ {{ $valor }}</b><br>
											<b>Data de pagamento:</b> Todo o dia {{ $date }}<br>
											<b>Forma de pagamento:</b> {{ $formaPag }}<br>
											<?php
											if(isset($obs)){
												echo "<b>Observação:</b> ".$obs;
											}
											?>
										</td>
									</tr>
									<tr>
										<td class="td" style="padding: 20px 0 30px 0;">
											Portanto, entre em contato pelos nossos canais oficiais (site, email, facebook, instagram ...) caso tenha alguma dúvida, algum problema com os serviços contratados ou qualquer outro.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- rodapé -->
			<tr>
				<td class="space_bottom">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="td" align="left">
								© 2020 Copyright | todos os direitos reservados a <br>
								<a href="https://agenciapublikando.com.br/">Agência Publikando</a>
							</td>
							<td align="right">
								<table border="0" cellpadding="10" cellspacing="0">
									<tr>
										<td>
											<a href="https://web.facebook.com/agenciapublikando/">
												<img src="{{ asset("assets/fb.png") }}" alt="Facebook" width="38" height="38" border="0"/>
											</a>
										</td>
										<td>
											<a href="https://www.instagram.com/agenciapublikando/">
												<img src="{{ asset("assets/ig.png") }}" alt="Instagram" width="38" height="38" border="0"/>
											</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
