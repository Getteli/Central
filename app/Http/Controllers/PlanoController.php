<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plano;
use App\Cliente;
use App\Entidade;
use App\Endereco;
use App\Contato;
use App\Licenses;

class PlanoController extends Controller
{

	public function list()
	{
		$valorTotal = 0;
		$planos = Plano::all()->where('ativo', 1);

		foreach ($planos as $key => $value) {
			$valorTotal += $value['preco'];
		}
		return view('content.plano.planos',compact('planos','valorTotal'));
	}

	public function filter(Request $request)
	{
		$filtrar = $request->all();

		$valorTotal = 0;

		// cria o objeto para a busca
		$planos = new Plano;

		// busca do usuario
		if (isset($filtrar['texto'])) {
			$planos = $planos->Where(function ($query) use($filtrar) {
				$query->where('descricao','LIKE','%'. $filtrar['texto'] .'%');
			});
		}
		if (isset($filtrar['preco'])) {
			$planos = $planos->where('preco','<=',$filtrar['preco']);
		}
		if (isset($filtrar['formaPagamento'])) {
			$planos = $planos->where('formaPagamento','=',$filtrar['formaPagamento']);
		}

		//padrao, buscar o que nao pode ser deletado E pega tudo em array
		$planos = $planos->Where(function ($query) {
			$query->where('deletado', '=', 0)
			->orWhere('deletado','=',null)
			->orWhere('deletado','!=',1);
		});
		$planos = $planos->get();

		foreach ($planos as $key => $value) {
			$valorTotal += $value['preco'];
		}

		if ($planos->isEmpty() || $planos->count() == 0) {
			\Session::flash('mensagem',['msg'=>'Sem resultados!','class'=>'green white-text']);
		}else{
			\Session::flash('mensagem', null);
		}

		return view('content.plano.planos',compact('planos','filtrar','valorTotal'));
	}

	public function editar($idPlano)
	{
		try{

			$cliente = Cliente::where('idPlano','=',$idPlano)->first();
			
			$entidade = Entidade::find($cliente->idEntidade);

			$enderecos = Endereco::where('idEntidade', '=', $cliente->idEntidade)->where('ativo', '=', 1)->get();

			if(!$enderecos){
				 $enderecos = null;
			}

			$contatos = Contato::where('idEntidade', '=', $cliente->idEntidade)->where('ativo', '=', 1)->get();

			if(!$contatos){
				$contatos = null;
			}

			$license = Licenses::where('codCliente', '=', $cliente->codCliente)->where('ativo', '=', 1)->first();

			if(!$license){
				 $license = null;
			}

			if(isset($cliente->idPlano)){
				$plano = Plano::find($cliente->idPlano);
			}else{
				$plano = null;
			}
			return view('content.cliente.editar', compact('cliente', 'entidade', 'plano', 'license', 'enderecos', 'contatos'));
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->route('clientes');
		}
	}

}