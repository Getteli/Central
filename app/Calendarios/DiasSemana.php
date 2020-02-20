<?php
namespace App\Calendarios;

abstract class DiasSemana
{
    const Domingo = 1;
    const SegundaFeira = 2;
    const TercaFeira = 3;
    const QuartaFeira = 4;
    const QuintaFeira = 5;
    const SextaFeira = 6;
    const Sabado = 7;

    // metodo para buscar todas as opcoes
    static function getAll(){
        
        $array = array(
            "Domingo" => 1,
            "SegundaFeira" => 2,
            "TercaFeira" => 3,
            "QuartaFeira" => 4,
            "QuintaFeira" => 5,
            "SextaFeira" => 6,
            "Sabado" => 7,
        );
        return $array;
    }
}