<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servico;

class ServicoController extends Controller
{
    public function adicionar(Request $request)
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
        }catch(Exception $e){
            //$e->getMessage();
            \Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
            return redirect()->back();
        }
    }

    public function atualizar(Request $request, $idServ)
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
        }catch(Exception $e){
            //$e->getMessage();
            \Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
            return redirect()->back();
        }
    }

    public function list()
    {
        $servicos = Servico::all();
        return view('content.servico.servicos',compact('servicos'));
    }

    public function editar($idServ)
    {
        $servico = Servico::find($idServ);
        
        return view('content.servico.editar', compact('servico'));
    }    
}