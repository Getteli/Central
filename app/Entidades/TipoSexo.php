<?php
namespace App\Entidades;

abstract class TipoSexo
{
    const Feminino = "M";
    const Masculino = "F";
    const Outros = "O";

    // metodo para buscar todas as opcoes
    static function getAll(){

        $array = array(
            "Feminino" => "F",
            "Masculino" => "M",
            "Outros" => "O",
        );
        return $array;
    }
}