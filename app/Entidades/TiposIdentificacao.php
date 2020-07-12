<?php
namespace App\Entidades;

abstract class TiposIdentificacao
{
	const Residencial = 1;
	const Comercial = 2;
	const Personalizado = 3;

		// metodo para buscar todas as opcoes
		static function getAll(){
		
			$array = array(
				"Residencial" => 1,
				"Comercial" => 2,
				"Filial" => 3,
				"Matriz" => 4,
				"Fixo" => 5,
				"Temporário" => 6,
				"Particular" => 7,
				// futuro, caso add mais, lembre-se que esta identificacao é usada no _formContato
				"Personalizado" => 8,
			);
			return $array;
		}
}