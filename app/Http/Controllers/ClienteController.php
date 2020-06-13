<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Entidade;
use App\Endereco;
use App\Contato;
use App\CodeRandom;
use App\Plano;
use App\Licenses;

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
			$entidade->dataNascimento = $dados['dataNascimento'];
			$entidade->apelido = $dados['apelido'];
			$entidade->sexo = $dados['sexo'];
			$entidade->naturalidade = $dados['naturalidade'];
			$entidade->nacionalidade = $dados['nacionalidade'];
			$entidade->save();

			// verifica se tem valor para registrar o endereço
			if(isset($dados['cep'])){
				$endereço = new Endereco();
				$endereço->numero = $dados['numero'];
				$endereço->descricao = $dados['descricaoEndereco'];
				$endereço->estado = $dados['estado'];
				$endereço->cidade = $dados['cidade'];
				$endereço->bairro = $dados['bairro'];
				$endereço->idEntidade = $entidade->idEntidade;
				$endereço->logradouro = $dados['logradouro'];
				$endereço->complemento = $dados['complemento'];
				$endereço->cep = $dados['cep'];
				$endereço->ativo = true;
				$endereço->save();
			}

			// verificar se tem valor para registrar contato
			if(isset($dados['numero'])){
				$contato = new Contato();				
				$contato->numero = $dados['numeroContato'];
				$contato->identificacao = $dados['identificacao'];
				$contato->ddd = $dados['ddd'];
				$contato->Email = $dados['emailContato'];
				$contato->idEntidade = $entidade->idEntidade;
				$contato->ativo = true;
				$contato->save();
			}
			
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
			$cliente->dataPagamento = $dados['dataPagamentoPlano'];
			$cliente->link = $dados['link'];
			$cliente->ativo = true;
			$cliente->idPlano = $plano->idPlano;
			$cliente->idEntidade = $entidade->idEntidade;
			$cliente->save();

			// cliente registrado com sucesso até aqui, agora crie um registro de licença
			$license = new Licenses();
			$license->codCliente = $cliente->codCliente;
			$license->dias = 31;
			$license->ativo = true;
			$license->dataLicense = $dados['dataPagamentoPlano'];
			// a data de licensa é o dia do pagamento. até chegar no dia de pagamento a primeira vez, o contador não transcorre
			$license->codLicense = $this->GetCodLicense($cliente->codCliente);
			$license->observacao = $dados['observacaoLicense'];
			$license->special = $dados['especialLicense'];
			$license->save();

			\Session::flash('mensagem',['msg'=>'Novo cliente criado com sucesso! Código do Cliente: '. $license->codLicense .'<br/>Crie o script na pasta do cliente e adicione o código dele.','class'=>'green white-text']);
			
			return redirect()->route('clientes');
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput($request->all);
		}
	}

	public function atualizar(Request $request, $idEnt, $idPla, $idCli, $idEnd = null, $idCont = null)
	{
		try{
			$dados = $request->all();

			// atualiza a entidade
			$entidade = Entidade::find($idEnt);
			$entidade->primeiroNome = $dados['primeiroNome'];
			$entidade->sobrenome = $dados['sobrenome'];
			$entidade->email = $dados['email'];
			$entidade->cpf = $dados['cpf'];
			$entidade->rg = $dados['rg'];
			$entidade->ativo = true;
			$entidade->orgaoEmissor = $dados['orgaoEmissor'];
			$entidade->dataExpedicao = $dados['dataExpedicao'];
			$entidade->dataNascimento = $dados['dataNascimento'];
			$entidade->apelido = $dados['apelido'];
			$entidade->sexo = $dados['sexo'];
			$entidade->naturalidade = $dados['naturalidade'];
			$entidade->nacionalidade = $dados['nacionalidade'];
			$entidade->update();
			
			// verifica se tem valor para registrar o endereço
			if(!$idEnd){
				$endereço = Endereco::find($idEnd);
				$endereço->numero = $dados['numero'];
				$endereço->descricao = $dados['descricaoEndereco'];
				$endereço->estado = $dados['estado'];
				$endereço->cidade = $dados['cidade'];
				$endereço->bairro = $dados['bairro'];
				$endereço->logradouro = $dados['logradouro'];
				$endereço->complemento = $dados['complemento'];
				$endereço->cep = $dados['cep'];
				//$endereço->ativo = true;
				$endereço->update();
			}

			// verificar se tem valor para registrar contato
			if(!$idCont){
				$contato = Contato::find($idCont);	
				$contato->numero = $dados['numeroContato'];
				$contato->identificacao = $dados['identificacao'];
				$contato->ddd = $dados['ddd'];
				$contato->Email = $dados['emailContato'];
				//$contato->ativo = true;
				$contato->update();
			}

			// atualiza o plano desse cliente
			$plano = Plano::find($idPla);
			$plano->descricao = $dados['descricao'];
			$plano->ativo = true;
			$plano->formaPagamento = $dados['formaPagamentoPlano'];
			$plano->preco = $dados['preco'];
			$plano->dataPagamento = $dados['dataPagamentoPlano'];
			$plano->update();

			// entao atualiza o cliente
			$cliente = Cliente::find($idCli);
			if($cliente){
				$cliente->cnpj = $dados['cnpj'];
				$cliente->razaoSocial = $dados['razaoSocial'];
				$cliente->dataPagamento = $dados['dataPagamentoPlano'];
				$cliente->link = $dados['link'];
				$cliente->update();
			}
			$license = Licenses::where('codCliente', '=', $cliente->codCliente)->first();

			if($license){
				$license->observacao = $dados['observacaoLicense'];
				$license->special = $dados['especialLicense'];
				// se ele atualizar a data de pagamento, atualizar a data de licença
				// planejar isto
				//$license->dataLicense = $dados['dataPagamentoPlano'];
				$license->update();				
			}


			\Session::flash('mensagem',['msg'=>'Cliente atualizado com sucesso!','class'=>'green white-text']);
			return redirect()->route('clientes');
		}catch(\Exception $e){
			//$e->getMessage();
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			return redirect()->back()->withInput($request->all);
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

		$endereco = Endereco::where('idEntidade', '=', $cliente->idEntidade)->first();

		if(!$endereco){
			 $endereco = null;
		}

		$contato = Contato::where('idEntidade', '=', $cliente->idEntidade)->first();

		if(!$contato){
			 $contato = null;
		}

		$license = Licenses::where('codCliente', '=', $cliente->codCliente)->first();

		if(!$license){
			 $license = null;
		}

		if(isset($cliente->idPlano)){
			$plano = Plano::find($cliente->idPlano);
		}else{
			$plano = null;
		}
		
		return view('content.cliente.editar', compact('cliente', 'entidade', 'plano', 'license', 'endereco', 'contato'));
	}

	public function GetCod(){
		$codP = new CodeRandom;
		$cod = $codP->CreateCod(5);
		return $cod;
	}
	public function GetCodLicense($codCli){
		$codP = new CodeRandom;
		$cod = $codP->CreateCodLicense($codCli);
		return $cod;
	}
}