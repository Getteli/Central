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
            "CartaoCredito" => 1,
            "CartaoDebito" => 2,
            "Boleto" => 3,
        );
        return $array;
    }

}