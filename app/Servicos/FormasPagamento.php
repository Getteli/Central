<?php

namespace App\Servicos;

abstract class FormasPagamento
{
	const CartaoCredito = 1;
	const CartaoDebito = 2;
	const Boleto = 3;

	// metodo para buscar todas as opcoes
	static function getAll(){
		
		$array = array(
			"Cartao de Crédito" => 1,
			"Cartao de Débito" => 2,
			"Boleto" => 3,
		);
		return $array;
	}

	static function formaPagamentoPorNome($idfp){
		$formas = self::getAll();
		$result = "Sem forma de Pagamento";
		foreach ($formas as $key => $value) {
			if ($idfp == $value) {
				$result = $key;
			}
		}
		return $result;
	}

}