<!DOCTYPE html>
<html>
<head>
	<title>Carregando...</title>
</head>
<body>
	<?php
		// url
		$url = "https://central.agenciapublikando.com.br/licenses/blockAll/";
		// código do cliente de licensa
		$codLicense = "";
		// Iniciamos a função do CURL:
		$cUrl = curl_init($url . $codLicense); // passa a url e o código
		// parametros
		curl_setopt_array($cUrl, [
			// request custom do tipo get
			CURLOPT_CUSTOMREQUEST => 'GET',
			// Permite obter o resultado
			CURLOPT_RETURNTRANSFER => 1,
		]);
		// get cUrl execute
		$result = curl_exec($cUrl);
		// close cUrl
		curl_close($cUrl);
		// result
		if ($result === "true") {
			// continua na página
		}else{
			header("Location: ops.html");
		}
	?>