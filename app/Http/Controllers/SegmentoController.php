<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Segmento;
use App\Servico;

class SegmentoController extends Controller
{
	public function adicionar(Request $request)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$segmento = new Segmento();
			$segmento->segmento = $dados['segmento'];
			$segmento->descricao = $dados['descricao'];
			$segmento->ativo = true;
			$segmento->save();

			\Session::flash('mensagem',['msg'=>'Novo segmento criado com sucesso!','class'=>'green white-text']);

			return redirect()->route('segmentos');
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput($request->all);
		}
	}

	public function atualizar(Request $request, $idSeg)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$segmento = Segmento::find($idSeg);
			$segmento->segmento = $dados['segmento'];
			$segmento->descricao = $dados['descricao'];
			$segmento->update();

			\Session::flash('mensagem',['msg'=>'Cliente atualizado com sucesso!','class'=>'green white-text']);
			
			return redirect()->route('segmentos');
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput($request->all);
		}
	}

	public function list()
	{
		$segmentos = Segmento::all()->where('ativo', 1);
		return view('content.segmento.segmentos',compact('segmentos'));
	}

	public function filter(Request $request)
	{
		$filtrar = $request->all();

		// cria o objeto para a busca
		$segmentos = new Segmento;

		// busca do usuario
		if (isset($filtrar['texto'])) {
			$segmentos = $segmentos->Where(function ($query) use($filtrar) {
				$query->where('segmento','LIKE','%'. $filtrar['texto'] .'%')
				->orWhere('descricao','LIKE','%'. $filtrar['texto'] .'%');
			});
		}
		if (isset($filtrar['status'])) {
			$segmentos = $segmentos->where('ativo','=',$filtrar['status']);
		}

		//padrao, buscar o que nao pode ser deletado E pega tudo em array
		$segmentos = $segmentos->Where(function ($query) {
			$query->where('deletado', '=', 0)
			->orWhere('deletado','=',null)
			->orWhere('deletado','!=',1);
		});
		$segmentos = $segmentos->get();

		if ($segmentos->isEmpty() || $segmentos->count() == 0) {
			\Session::flash('mensagem',['msg'=>'Sem resultados!','class'=>'green white-text']);
		}else{
			\Session::flash('mensagem', null);
		}

		return view('content.segmento.segmentos',compact('segmentos','filtrar'));
	}

	public function editar($idSeg)
	{
		$segmento = Segmento::find($idSeg);
		
		return view('content.segmento.editar', compact('segmento'));
	}

	public function desativarSegmento($idSeg)
	{
		try {
			$segmento = Segmento::find($idSeg);
			$segmento->ativo = false;
			$segmento->update();

			$servicos = Servico::where("idSegmento","=",$segmento->idSegmento)->get();
			foreach ($servicos as $key => $servico) {
				$servico->ativo = false;
				$servico->update();
			}

			if ($segmento && $servicos) {
				\Session::flash('mensagem',['msg'=>'Segmento desativado com sucesso.','class'=>'green white-text']);
				return redirect()->route('segmentos');
			}
		} catch (Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput();
		}
	}

	public function ativarSegmento($idSeg)
	{
		try {
			$segmento = Segmento::find($idSeg);
			$segmento->ativo = true;
			$segmento->update();

			$servicos = Servico::where("idSegmento","=",$segmento->idSegmento)->get();
			foreach ($servicos as $key => $servico) {
				$servico->ativo = true;
				$servico->update();
			}

			if ($segmento && $servicos) {
				\Session::flash('mensagem',['msg'=>'Segmento ativado com sucesso.','class'=>'green white-text']);
				return redirect()->route('segmentos');
			}
		} catch (Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput();
		}
	}

	public function deleteSegmento($idSeg)
	{
		try {
			$segmento = Segmento::find($idSeg);
			$segmento->ativo = false;
			$segmento->deletado = true;
			$segmento->update();

			$servicos = Servico::where("idSegmento","=",$segmento->idSegmento)->get();
			foreach ($servicos as $key => $servico) {
				$servico->ativo = false;
				$servico->deletado = true;
				$servico->update();
			}

			if ($segmento && $servicos) {
				\Session::flash('mensagem',['msg'=>'Segmento deletado com sucesso.','class'=>'green white-text']);
				return redirect()->route('segmentos');
			}
		} catch (Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput();
		}
	}

}