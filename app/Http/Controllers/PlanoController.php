<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servicos\Plano;

class PlanoController extends Controller
{

	public function list()
	{
		// acessa o método para buscar a lista de planos
		$plano = new Plano();
		return $plano->Listagem();
	}

	public function filter(Request $request)
	{
		$plano = new Plano();
		return $plano->Filtro($request);
	}

	public function editar($idPlano)
	{
		$plano = new Plano();
		return $plano->EditarPlano($idPlano);
	}

}
