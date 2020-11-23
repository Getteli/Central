<?php
  // globais de notification
  define("EMAIL_PAGSEGURO", "matheus.me.ngo@hotmail.com");
  define("TOKEN_PAGSEGURO", "E1F464F81D524DF88D07E00B37B7994F");

  // link para acessar o pagseguro
  $url = "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$_POST['notificationCode']}?email=".EMAIL_PAGSEGURO."&token=".TOKEN_PAGSEGURO."";

  // primeiro acesso cURL: pagseguro
  $cURL = curl_init($url); // passa a url
  curl_setopt_array($cURL, [
  // parametros
    CURLOPT_SSL_VERIFYPEER => TRUE,
    // Permite obter o resultado
    CURLOPT_RETURNTRANSFER => TRUE
  ]);
  // get cURL execute
  $return = curl_exec($cURL);
  // close cUrl
  curl_close($cURL);
  // convert to xml
  $xml = simplexml_load_string($return);
  $cod = $xml->reference;
  $status = $xml->status;

  // agora com o resultado do pagseguro, execute a notificação do sistema central
  $notify = "https://central.agenciapublikando.com.br/licenses/UpdatePaymenteCliente/$cod/$status";

  // segundo acesso cURL: central
	$cURL2 = curl_init($notify); // passa a url e o código
  curl_setopt_array($cURL2, [
	// parametros
		// request custom do tipo get
		CURLOPT_CUSTOMREQUEST => 'GET',
		// Permite obter o resultado
		CURLOPT_RETURNTRANSFER => 1,
    // serguir o local que o http mande
    CURLOPT_FOLLOWLOCATION => true,
	]);
  $execute = curl_exec($cURL2);
	// close cUrl
	curl_close($cURL2);
?>
