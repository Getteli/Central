<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SegmentoRequest;
use App\Servicos\Segmento;
use App\Servicos\Servico;

class SegmentoController extends Controller
{

	public function adicionar(SegmentoRequest $request)
	{
		// acessa o método para add um novo segmento
		$segmento = new Segmento();
		return $segmento->CreateSegmento($request);
	}

	public function atualizar(SegmentoRequest $request, $idSeg)
	{
		// acessa o método para atualizar segmento
		$segmento = new Segmento();
		return $segmento->UpdateSegmento($request, $idSeg);
	}

	public function list()
	{
		$segmento = new Segmento();
		return $segmento->Listagem();
	}

	public function filter(Request $request)
	{
		$segmento = new Segmento();
		return $segmento->Filtro($request);
	}

	public function editar($idSeg)
	{
		$segmento = new Segmento();
		return $segmento->EditarSegmento($idSeg);
	}

	public function desativarSegmento($idSeg)
	{
		$segmento = new Segmento();
		return $segmento->Desativar($idSeg);
	}

	public function ativarSegmento($idSeg)
	{
		$segmento = new Segmento();
		return $segmento->Ativar($idSeg);
	}

	public function deleteSegmento($idSeg)
	{
		$segmento = new Segmento();
		return $segmento->Deletar($idSeg);
	}

}
