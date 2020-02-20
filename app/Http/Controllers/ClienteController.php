<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Entidade;
use App\CodeRandom;
use App\Plano;

class ClienteController extends Controller
{

    public function adicionar(Request $request)
    {
        try{
            $dados = $request->all();

            // cria a entidade
            $entidade = new Entidade();
            $entidade->primeiroNome = $dados['primeiroNome'];
            $entidade->sobrenome = $dados['sobrenome'];
            $entidade->email = $dados['email'];
            $entidade->cpf = $dados['cpf'];
            $entidade->rg = $dados['rg'];
            $entidade->ativo = true;
            $entidade->orgaoEmissor = $dados['orgaoEmissor'];
            $entidade->dataExpedicao = $dados['dataExpedicao'];
            $entidade->apelido = $dados['apelido'];
            $entidade->sexo = $dados['sexo'];
            $entidade->naturalidade = $dados['naturalidade'];
            $entidade->nacionalidade = $dados['nacionalidade'];
            $entidade->save();
            
            // criar o plano desse cliente
            $plano = new Plano();
            $plano->descricao = $dados['descricao'];
            $plano->ativo = true;
            $plano->formaPagamento = $dados['formaPagamentoPlano'];
            $plano->preco = $dados['preco'];
            $plano->dataPagamento = $dados['dataPagamentoPlano'];
            $plano->save();

            // entao cria o cliente
            $cliente = new Cliente();
            $cliente->codCliente = $this->GetCod();
            $cliente->cnpj = $dados['cnpj'];
            $cliente->razaoSocial = $dados['razaoSocial'];
            $cliente->dataPagamento = $dados['dataPagamento'];
            $cliente->link = $dados['link'];
            $cliente->idPlano = $plano->id;
            $cliente->idEntidade = $entidade->id;
            $cliente->save();

            \Session::flash('mensagem',['msg'=>'Novo cliente criado com sucesso!','class'=>'green white-text']);
            
            return redirect()->route('clientes');
        }catch(Exception $e){
            //$e->getMessage();
            \Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
            return redirect()->back();
        }
    }

    public function atualizar(Request $request, $idEnt, $idPla, $idCli)
    {
        try{
            $dados = $request->all();

            // cria a entidade
            $entidade = Entidade::find($idEnt);
            $entidade->primeiroNome = $dados['primeiroNome'];
            $entidade->sobrenome = $dados['sobrenome'];
            $entidade->email = $dados['email'];
            $entidade->cpf = $dados['cpf'];
            $entidade->rg = $dados['rg'];
            $entidade->ativo = true;
            $entidade->orgaoEmissor = $dados['orgaoEmissor'];
            $entidade->dataExpedicao = $dados['dataExpedicao'];
            $entidade->apelido = $dados['apelido'];
            $entidade->sexo = $dados['sexo'];
            $entidade->naturalidade = $dados['naturalidade'];
            $entidade->nacionalidade = $dados['nacionalidade'];
            $entidade->update();
            
            // criar o plano desse cliente
            $plano = Plano::find($idPla);
            $plano->descricao = $dados['descricao'];
            $plano->ativo = true;
            $plano->formaPagamento = $dados['formaPagamentoPlano'];
            $plano->preco = $dados['preco'];
            $plano->dataPagamento = $dados['dataPagamentoPlano'];
            $plano->update();

            // entao cria o cliente
            $cliente = Cliente::find($idCli);
            $cliente->codCliente = $this->GetCod();
            $cliente->cnpj = $dados['cnpj'];
            $cliente->razaoSocial = $dados['razaoSocial'];
            $cliente->dataPagamento = $dados['dataPagamento'];
            $cliente->link = $dados['link'];
            $cliente->idPlano = $plano->id;
            $cliente->idEntidade = $entidade->id;
            $cliente->update();

            \Session::flash('mensagem',['msg'=>'Cliente atualizado com sucesso!','class'=>'green white-text']);
            return redirect()->route('clientes');
        }catch(Exception $e){
            //$e->getMessage();
            \Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
            return redirect()->back();
        }
    }

    public function list()
    {
        $clientes = Cliente::all();
        return view('content.cliente.clientes',compact('clientes'));
    }

    public function editar($idCli, $idEnt)
    {
        $cliente = Cliente::find($idCli);
        
        $entidade = Entidade::find($idEnt);

        if(isset($cliente->idPlano)){
            $plano = Plano::find($cliente->idPlano);
        }else{
            $plano = null;
        }
        
        return view('content.cliente.editar', compact('cliente', 'entidade', 'plano'));
    }

    public function GetCod(){
        $codP = new CodeRandom;
        $cod = $codP->CreateCod(5);
        return $cod;
    }
}