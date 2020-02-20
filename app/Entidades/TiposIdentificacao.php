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
                "Personalizado" => 3,
            );
            return $array;
        }
}