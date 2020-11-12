<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServicoRequest;
use App\Servicos\Servico;

class ServicoController extends Controller
{
	public function adicionar(ServicoRequest $request)
	{
		// acessa o método para add um novo serviço
		$servico = new Servico();
		return $servico->CreateServico($request);
	}

	public function atualizar(ServicoRequest $request, $idServ)
	{
		$servico = new Servico();
		return $servico->UpdateServico($request, $idServ);
	}

	public function list()
	{
		$servico = new Servico();
		return $servico->Listagem();
	}

	public function filter(Request $request)
	{
		$servico = new Servico();
		return $servico->Filtro($request);
	}

	public function editar($idServ)
	{
		$servico = new Servico();
		return $servico->Editar($idServ);
	}

	public function desativarServico($idServ)
	{
		$servico = new Servico();
		return $servico->Desativar($idServ);
	}

	public function ativarServico($idServ)
	{
		$servico = new Servico();
		return $servico->Ativar($idServ);
	}

	public function deleteServico($idServ)
	{
		$servico = new Servico();
		return $servico->Deletar($idServ);
	}

	public static function listagemComSegmento(Request $request)
	{
		$servico = new Servico();
		return $servico->ListagemComSegmento($request);
	}

}
