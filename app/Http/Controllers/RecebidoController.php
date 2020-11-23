<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contas\Recebido;

class RecebidoController extends Controller
{

	public function list()
	{
		// acessa o método para buscar a lista de recebidos
		$recebido = new Recebido();
		return $recebido->Listagem();
	}

	public function filter(Request $request)
	{
		$recebido = new Recebido();
		return $recebido->Filtro($request);
	}

	public function editar($idRecebido)
	{
		$recebido = new Recebido();
		return $recebido->EditarPlano($idRecebido);
	}

	public function verCliente($idPlano)
	{
		$recebido = new Recebido();
		return $recebido->VerCliente($idPlano);
	}
}
