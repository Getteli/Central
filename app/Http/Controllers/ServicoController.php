<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServicoRequest;
use App\Servico;

class ServicoController extends Controller
{
	public function adicionar(ServicoRequest $request)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$servico = new Servico();
			$servico->servico = $dados['servico'];
			$servico->descricao = $dados['descricao'];
			$servico->idSegmento = $dados['idSegmento'];
			$servico->preco = $dados['preco'];
			$servico->ativo = true;
			$servico->save();

			\Session::flash('mensagem',['msg'=>'Novo serviço criado com sucesso!','class'=>'green white-text']);

			return redirect()->route('servicos');
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput($request->all);
		}
	}

	public function atualizar(ServicoRequest $request, $idServ)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$servico = Servico::find($idServ);
			$servico->servico = $dados['servico'];
			$servico->descricao = $dados['descricao'];
			$servico->idSegmento = $dados['idSegmento'];
			$servico->preco = $dados['preco'];
			$servico->update();

			\Session::flash('mensagem',['msg'=>'Serviço atualizado com sucesso!','class'=>'green white-text']);
			
			return redirect()->route('servicos');
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput($request->all);
		}
	}

	public function list()
	{
		$servicos = Servico::all()->where('ativo', 1);
		return view('content.servico.servicos',compact('servicos'));
	}

	public function filter(Request $request)
	{
		$filtrar = $request->all();

		// cria o objeto para a busca
		$servicos = new Servico;

		// busca do usuario
		if (isset($filtrar['texto'])) {
			$servicos = $servicos->Where(function ($query) use($filtrar) {
				$query->where('servico','LIKE','%'. $filtrar['texto'] .'%')
				->orWhere('descricao','LIKE','%'. $filtrar['texto'] .'%');
			});
		}
		if (isset($filtrar['status'])) {
			$servicos = $servicos->where('ativo','=',$filtrar['status']);
		}
		if (isset($filtrar['segmento'])) {
			$servicos = $servicos->where('idSegmento','=',$filtrar['segmento']);
		}

		//padrao, buscar o que nao pode ser deletado E pega tudo em array
		$servicos = $servicos->Where(function ($query) {
			$query->where('deletado', '=', 0)
			->orWhere('deletado','=',null)
			->orWhere('deletado','!=',1);
		});
		$servicos = $servicos->get();

		if ($servicos->isEmpty() || $servicos->count() == 0) {
			\Session::flash('mensagem',['msg'=>'Sem resultados!','class'=>'green white-text']);
		}else{
			\Session::flash('mensagem', null);
		}

		return view('content.servico.servicos',compact('servicos','filtrar'));
	}

	public function editar($idServ)
	{
		$servico = Servico::find($idServ);
		
		return view('content.servico.editar', compact('servico'));
	}


	public function desativarServico($idServ)
	{
		try {
			$servico = Servico::find($idServ);
			$servico->ativo = false;
			$servico->update();

			if ($servico) {
				\Session::flash('mensagem',['msg'=>'Serviço desativado com sucesso.','class'=>'green white-text']);
				return redirect()->route('servicos');
			}
		} catch (Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput();
		}
	}

	public function ativarServico($idServ)
	{
		try {
			$servico = Servico::find($idServ);
			$servico->ativo = true;
			$servico->update();

			if ($servico) {
				\Session::flash('mensagem',['msg'=>'Serviço ativado com sucesso.','class'=>'green white-text']);
				return redirect()->route('servicos');
			}
		} catch (Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput();
		}
	}

	public function deleteServico($idServ)
	{
		try {
			$servico = Servico::find($idServ);
			$servico->ativo = false;
			$servico->deletado = true;
			$servico->update();

			if ($servico) {
				\Session::flash('mensagem',['msg'=>'Serviço deletado com sucesso.','class'=>'green white-text']);
				return redirect()->route('servicos');
			}
		} catch (Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput();
		}
	}


	public static function listagemComSegmento(Request $request)
	{
		$idSegmento = $request->idSegmento; // id a pesquisar do segmento
		$arrayServicos = array(); // array que armazenará
		$i = 0; // contador

		foreach ( Servico::Where('idSegmento','=', $idSegmento)->get() as $Servico) {
			$arrayServicos[$i]['preco'] = $Servico['preco'];
			$arrayServicos[$i]['servico'] = $Servico['servico'];
			$i++; // incrementa
		}

		// retorna o array encapsulado como um json para o javascript
		return json_encode($arrayServicos);


		// CASO FOR USAR ESTA FUNCAO DE LISTAGEM, SEGUE O EXEMPLO
		/*
	document.getElementById("idSegmento").addEventListener("change", function(){
		// manda o token como cabecalho
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			}
		});
		$.ajax({
			url: "{{ route('servico.ListagemComSegmento') }}",
			type: "POST",
			data: {
				'idSegmento': this.value
			},
			success: function(response){
				// converte em objeto o resultado do php
				var obj = jQuery.parseJSON(response);
				// pega o select pelo id
				var selectList = document.getElementById("idServico");

				// remove todas as opções anteriores
				for (i = selectList.length - 1; i >= 0; i--) {
					// se for o option padrao de selecione, nao o remova
					if (selectList.options[i].value != -1) {
						selectList.remove(i);
					}
				}

				// popula o select com o resultado do php
				for(var k in obj) {
					var option = document.createElement("option");
					option.value = obj[k]['preco'];
					option.text = obj[k]['servico'];
					selectList.appendChild(option);
				}

				// atualiza o select do materialize para renderizar no DOM
				$('select').formSelect();
			},
			error: function(response){
				// se der erro, não faça nada
			}
		});
	});
	
		*/
	}

}