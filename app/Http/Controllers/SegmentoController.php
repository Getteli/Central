<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Segmento;

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
        }catch(Exception $e){
            //$e->getMessage();
            \Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
            return redirect()->back();
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
        }catch(Exception $e){
            //$e->getMessage();
            \Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
            return redirect()->back();
        }
    }

    public function list()
    {
        $segmentos = Segmento::all();
        return view('content.segmento.segmentos',compact('segmentos'));
    }

    public function editar($idSeg)
    {
        $segmento = Segmento::find($idSeg);
        
        return view('content.segmento.editar', compact('segmento'));
    }    
}