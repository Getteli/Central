<?php
namespace App\Entidades;

abstract class TiposEntidade
{
    const Usuario = 1;
    const Cliente = 2;

    // metodo para buscar todas as opcoes
    static function getAll(){

        $array = array(
            "Usuario" => 1,
            "Cliente" => 2,
        );
        return $array;
    }
}