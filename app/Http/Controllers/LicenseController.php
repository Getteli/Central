<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Entidade;
use App\Licenses;

class LicenseController extends Controller
{
	public function blockall($codLicense)
	{
		// busca a licença pelo codigo
		$licenseCliente = Licenses::where('codLicense','=',$codLicense)->first();
		// verifica se existe o registro
		if (!$licenseCliente) {
			echo "false";
		}else{
			// pega os dias
			$dias = $licenseCliente->dias;
			if ($dias >= 0) {
				echo "true";
			}else{
				// impede de entrar no site e envia um email para este cliente
				$codCliente = $licenseCliente->codCliente;
				$cliente = Cliente::where('codCliente','=',$codCliente)->first();
				$entidade = Entidade::find($cliente->idEntidade);
				//funcao de enviar email
				//$entidade->email
				echo "false";
			}
		}
	}
}