<?php
// este arquivo fica dentro do sistema da Central
// caminho App\Http\Controllers
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Entidade;
use App\Licenses;

class LicenseController extends Controller
{
	// no controller, pega o que veio pelo cURL, e executa o metodo pelo model
	public function blockall($codLicense)
	{
		$license = new Licenses();
		echo $license->VerifyLicense($codLicense);
	}

	// e no model do objeto de licensa, que liga com o banco, executa este metodo abaixo:
	public function VerifyLicense($codLicense)
	{
		// busca a licença pelo codigo
		$licenseCliente = Licenses::where([['codLicense','=',$codLicense],
		['ativo','=',1]])
		->Where(function ($query) {
			$query->where('deletado','=',0)
			->orWhere('deletado','=',null);
		})
		->first();
		// verifica se existe o registro
		if (!$licenseCliente) {
			return "false";
		}else{
			// pega os dias
			$dias = $licenseCliente->dias;
			if ($dias >= 0) {
				return "true";
			}else{
				// impede de entrar no site e envia um email para este cliente
				$codCliente = $licenseCliente->codCliente;
				$cliente = Cliente::where('codCliente','=',$codCliente)->first();
				$entidade = Entidade::find($cliente->idEntidade);
				//funcao de enviar email
				//$entidade->email
				return "false";
			}
		}
	}
}