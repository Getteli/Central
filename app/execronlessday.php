<?php
  /* este arquivo, serve para rodar os cron's no servidor
  assim, todo o sistema de rodar o script pelo link, acessando o metodo, que acessa o bd do central e etc
  funciona perfeitamente.
  CRON: Diminuir os dias da linceça do cliente.
  */

  // Acesse o link via cURL, para executar o cron

  $url = 'https://central.agenciapublikando.com.br/cron/lessDay/';

	// Iniciamos a função do CURL:
	$cUrl = curl_init($url); // passa a url e o código
  curl_setopt_array($cUrl, [
	// parametros
		// request custom do tipo get
		CURLOPT_CUSTOMREQUEST => 'GET',
		// Permite obter o resultado
		CURLOPT_RETURNTRANSFER => 1,
    // serguir o local que o http mande
    CURLOPT_FOLLOWLOCATION => true,
	]);
	// get cURL execute
	$result = curl_exec($cUrl);

	// close cUrl
	curl_close($cUrl);
?>
