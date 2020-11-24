<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DespesaRequest;
use App\Contas\Despesa;

class DespesaController extends Controller
{

	public function list()
	{
		// acessa o método para buscar a lista de despesas
		$despesa = new Despesa();
		return $despesa->Listagem();
	}

	public function filter(Request $request)
	{
		$despesa = new Despesa();
		return $despesa->Filtro($request);
	}

	public function adicionar(DespesaRequest $request)
	{
		$despesa = new Despesa();
		return $despesa->CreateDespesa($request);
	}
}
