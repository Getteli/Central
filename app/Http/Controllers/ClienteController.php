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

			// passa os dados do formulario de endereco
			$arrayE = array_filter($_POST["enderecoForm"]);
			// array que guardará cada endereco
			$endereco = array();
			// organiza cada elemento em um unico array com chaves, para cada novo endereco
			foreach ($arrayE as $chave1 => $arrayI) {
				foreach ($arrayI as $chave2 => $valor) {
					if(!empty($valor)){
						$endereco[$chave2][$chave1] = $valor;
					}
				}
			}
			// add o endereco
			foreach ($endereco as $k => $arrayInterno) {
				$endereco = new Endereco();
				$endereco->cep = isset($arrayInterno['cep']) ? $arrayInterno['cep'] : null;
				$endereco->logradouro = isset($arrayInterno['logradouro']) ? $arrayInterno['logradouro'] : null;
				$endereco->numero = isset($arrayInterno['numero']) ? $arrayInterno['numero'] : null;
				$endereco->complemento = isset($arrayInterno['complemento']) ? $arrayInterno['complemento'] : null;
				$endereco->estado = isset($arrayInterno['estado']) ? $arrayInterno['estado'] : null;
				$endereco->cidade = isset($arrayInterno['cidade']) ? $arrayInterno['cidade'] : null;
				$endereco->bairro = isset($arrayInterno['bairro']) ? $arrayInterno['bairro'] : null;
				$endereco->descricao = isset($arrayInterno['descricaoEndereco']) ? $arrayInterno['descricaoEndereco'] : null;
				$endereco->idEntidade = $entidade->idEntidade;
				$endereco->ativo = true;
				$endereco->save();
				break;
			}

			// passa os dados do formulario de contato
			$array = array_filter($_POST["contatoForm"]);
			// array que guardará cada contato
			$contato = array();
			// organiza cada elemento em um unico array com chaves, para cada novo contato
			foreach ($array as $chave1 => $arrayI) {
				foreach ($arrayI as $chave2 => $valor) {
					if(!empty($valor)){
						$contato[$chave2][$chave1] = $valor;
					}
				}
			}
			// add o contato
			foreach ($contato as $k => $arrayInterno) {
				$contato = new Contato();
				$contato->ddd = isset($arrayInterno['ddd']) ? $arrayInterno['ddd'] : null;
				$contato->numero = isset($arrayInterno['numeroContato']) ? $arrayInterno['numeroContato'] : null;
				$contato->Email = isset($arrayInterno['emailContato']) ? $arrayInterno['emailContato'] : null;
				$contato->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] : null;
				$contato->idEntidade = $entidade->idEntidade;
				$contato->ativo = true;
				$contato->save();
				break;
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
			$license->dias = 31; //padrao começa com 31 dias
			$license->ativo = true;
			// a data de licensa é o dia do pagamento. até chegar no dia de pagamento a primeira vez, o contador não transcorre
			$license->dataLicense = $dados['dataPagamentoPlano'];
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

	public function atualizar(Request $request, $idEnt, $idPla, $idCli)
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
			
			// passa os dados do formulario de endereco
			$arrayE = array_filter($_POST["enderecoForm"]);
			// array que guardará cada endereco
			$endereco = array();
			// verificar se tem valor para registrar endereco
			$enderecoBanco = Endereco::where('idEntidade', '=', $idEnt)->get();
			// organiza cada elemento em um unico array com chaves, para cada novo endereco
			foreach ($arrayE as $chave1 => $arrayI) {
				foreach ($arrayI as $chave2 => $valor) {
					if(!empty($valor)){
						$endereco[$chave2][$chave1] = $valor;
					}
				}
			}
			// add o endereco
			foreach ($endereco as $k => $arrayInterno) {
				// se nao existe no banco, entao é um novo
				if($enderecoBanco->isEmpty()){
					$NovoEndereco = new Endereco();
					$NovoEndereco->cep = isset($arrayInterno['cep']) ? $arrayInterno['cep'] : null;
					$NovoEndereco->logradouro = isset($arrayInterno['logradouro']) ? $arrayInterno['logradouro'] : null;
					$NovoEndereco->numero = isset($arrayInterno['numero']) ? $arrayInterno['numero'] : null;
					$NovoEndereco->complemento = isset($arrayInterno['complemento']) ? $arrayInterno['complemento'] : null;
					$NovoEndereco->estado = isset($arrayInterno['estado']) ? $arrayInterno['estado'] : null;
					$NovoEndereco->cidade = isset($arrayInterno['cidade']) ? $arrayInterno['cidade'] : null;
					$NovoEndereco->bairro = isset($arrayInterno['bairro']) ? $arrayInterno['bairro'] : null;
					$NovoEndereco->descricao = isset($arrayInterno['descricaoEndereco']) ? $arrayInterno['descricaoEndereco'] : null;
					$NovoEndereco->idEntidade = $entidade->idEntidade;
					$NovoEndereco->ativo = true;
					$NovoEndereco->save();
				}
				//passa pelo array do banco
				foreach ($enderecoBanco as $key => $value) {
					// se existe entao atualiza, se nao, é um novo contato
					if (isset($enderecoBanco[$k])) {
						$enderecoBanco[$k]->cep = isset($arrayInterno['cep']) ? $arrayInterno['cep'] : null;
						$enderecoBanco[$k]->logradouro = isset($arrayInterno['logradouro']) ? $arrayInterno['logradouro'] : null;
						$enderecoBanco[$k]->numero = isset($arrayInterno['numero']) ? $arrayInterno['numero'] : null;
						$enderecoBanco[$k]->complemento = isset($arrayInterno['complemento']) ? $arrayInterno['complemento'] : null;
						$enderecoBanco[$k]->estado = isset($arrayInterno['estado']) ? $arrayInterno['estado'] : null;
						$enderecoBanco[$k]->cidade = isset($arrayInterno['cidade']) ? $arrayInterno['cidade'] : null;
						$enderecoBanco[$k]->bairro = isset($arrayInterno['bairro']) ? $arrayInterno['bairro'] : null;
						$enderecoBanco[$k]->descricao = isset($arrayInterno['descricaoEndereco']) ? $arrayInterno['descricaoEndereco'] : null;
						$enderecoBanco[$k]->update();
					}else{
						$NovoEndereco = new Endereco();
						$NovoEndereco->cep = isset($arrayInterno['cep']) ? $arrayInterno['cep'] : null;
						$NovoEndereco->logradouro = isset($arrayInterno['logradouro']) ? $arrayInterno['logradouro'] : null;
						$NovoEndereco->numero = isset($arrayInterno['numero']) ? $arrayInterno['numero'] : null;
						$NovoEndereco->complemento = isset($arrayInterno['complemento']) ? $arrayInterno['complemento'] : null;
						$NovoEndereco->estado = isset($arrayInterno['estado']) ? $arrayInterno['estado'] : null;
						$NovoEndereco->cidade = isset($arrayInterno['cidade']) ? $arrayInterno['cidade'] : null;
						$NovoEndereco->bairro = isset($arrayInterno['bairro']) ? $arrayInterno['bairro'] : null;
						$NovoEndereco->descricao = isset($arrayInterno['descricaoEndereco']) ? $arrayInterno['descricaoEndereco'] : null;
						$NovoEndereco->idEntidade = $entidade->idEntidade;
						$NovoEndereco->ativo = true;
						$NovoEndereco->save();
					}
					break;
				}
			}

			// passa os dados do formulario de contato
			$array = array_filter($_POST["contatoForm"]);
			// array que guardará cada contato
			$contato = array();
			// verificar se tem valor para registrar contato
			$contatoBanco = Contato::where('idEntidade', '=', $idEnt)->get();
			// organiza cada elemento em um unico array com chaves, para cada novo contato
			foreach ($array as $chave1 => $arrayI) {
				foreach ($arrayI as $chave2 => $valor) {
					if(!empty($valor)){
						$contato[$chave2][$chave1] = $valor;
					}
				}
			}

			// add o contato
			foreach ($contato as $k => $arrayInterno) {
				// se nao existe no banco, entao é um novo
				if($contatoBanco->isEmpty()){
					$NovoContato = new Contato();
					$NovoContato->ddd = isset($arrayInterno['ddd']) ? $arrayInterno['ddd'] : null;
					$NovoContato->numero = isset($arrayInterno['numeroContato']) ? $arrayInterno['numeroContato'] : null;
					$NovoContato->Email = isset($arrayInterno['emailContato']) ? $arrayInterno['emailContato'] : null;
					$NovoContato->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] : null;
					$NovoContato->idEntidade = $entidade->idEntidade;
					$NovoContato->ativo = true;
					$NovoContato->save();	
				}
				//passa pelo array do banco
				foreach ($contatoBanco as $key => $value) {
					// se existe entao atualiza, se nao, é um novo contato
					if (isset($contatoBanco[$k])) {
						$contatoBanco[$k]->ddd = isset($arrayInterno['ddd']) ? $arrayInterno['ddd'] : null;
						$contatoBanco[$k]->numero = isset($arrayInterno['numeroContato']) ? $arrayInterno['numeroContato'] : null;
						$contatoBanco[$k]->Email = isset($arrayInterno['emailContato']) ? $arrayInterno['emailContato'] : null;
						$contatoBanco[$k]->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] : null;
						$contatoBanco[$k]->update();
					}else{
						$NovoContato = new Contato();
						$NovoContato->ddd = isset($arrayInterno['ddd']) ? $arrayInterno['ddd'] : null;
						$NovoContato->numero = isset($arrayInterno['numeroContato']) ? $arrayInterno['numeroContato'] : null;
						$NovoContato->Email = isset($arrayInterno['emailContato']) ? $arrayInterno['emailContato'] : null;
						$NovoContato->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] : null;
						$NovoContato->idEntidade = $entidade->idEntidade;
						$NovoContato->ativo = true;
						$NovoContato->save();						
					}
					break;
				}
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

		$enderecos = Endereco::where('idEntidade', '=', $cliente->idEntidade)->get();

		if(!$enderecos){
			 $enderecos = null;
		}

		$contatos = Contato::where('idEntidade', '=', $cliente->idEntidade)->get();

		if(!$contatos){
			$contatos = null;
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
		
		return view('content.cliente.editar', compact('cliente', 'entidade', 'plano', 'license', 'enderecos', 'contatos'));
	}

	public static function deleteContato(Request $request)
	{
		$idContato = $request->idContato; //
		try {
			$contato = Contato::find($idContato)->delete();
			if ($contato) {
				return "deletado com sucesso";
			}
		} catch (Exception $e) {
			return $e;
		}
	}

	public static function deleteEndereco(Request $request)
	{
		$idEndereco = $request->idEndereco; //
		try {
			$endereco = Endereco::find($idEndereco)->delete();
			if ($endereco) {
				return "deletado com sucesso";
			}
		} catch (Exception $e) {
			return $e;
		}
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