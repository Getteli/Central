<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntidadeRequest;
use App\Entidades\Cliente;
use App\Entidades\Entidade;
use App\Entidades\Endereco;
use App\Entidades\Contato;
use App\CodeRandom;
use App\Servicos\Plano;
use App\Licenses;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class ClienteController extends Controller
{

	public function adicionar(EntidadeRequest $request)
	{
		// cria o objeto entidade para começar a criacao do cliente
		$newEntidade = new Entidade();
		$entidade = $newEntidade->CreateEntidadeCliente($request);

		if(!$entidade){
			return redirect()->back()->withInput($request->all);
		}

		// tendo ou não, passa pelo metodo de criar endereços
		$newEnderecos = new Endereco();
		$enderecos = $newEnderecos->CreateEnderecoCliente($request, $entidade->idEntidade);

		if(!$enderecos){
			return redirect()->back()->withInput($request->all);
		}

		// tendo ou não, passa pelo metodo de criar contatos
		$newContatos = new Contato();
		$contatos = $newContatos->CreateContatoCliente($request, $entidade->idEntidade);

		if(!$contatos){
			return redirect()->back()->withInput($request->all);
		}

		$newPlano = new Plano();
		$plano = $newPlano->CreatePlanoCliente($request);

		if(!$plano){
			return redirect()->back()->withInput($request->all);
		}

		$newCliente = new Cliente();
		$cliente = $newCliente->CreateCliente($request, $plano->idPlano, $entidade->idEntidade);

		if(!$cliente){
			return redirect()->back()->withInput($request->all);
		}

		$newLicense = new Licenses();
		// se criar com sucesso a licensa do cliente
		$license = $newLicense->CreateLicenseCliente($request, $cliente->codCliente);

		if(!$license){
			return redirect()->back()->withInput($request->all);
		}

		\Session::flash('mensagem',[
			'title'=> 'Criar um novo Cliente',
			'msg'=> 'Novo cliente criado com sucesso ! Código do Cliente: '. $license->codLicense .'. Crie o script na pasta do cliente e adicione o código dele.',
			'class'=> 'green white-text modal-show',
			'class-mc'=> 'green',
			'class-so'=> 'sidenav-overlay-show'
			]);

		// envia email de criacao do novo cliente
		// envia o obj cliente, entidade, license
		Mail::to($entidade->email)->send(new WelcomeMail($cliente, $entidade, $license));

		return redirect()->route('clientes');
	}

	public function atualizar(EntidadeRequest $request, $idEnt, $idPla, $idCli)
	{
			// cria o objeto entidade para começar a criacao do cliente
			$newEntidade = new Entidade();
			$entidade = $newEntidade->UpdateEntidadeCliente($request, $idEnt);

			if(!$entidade){
				return redirect()->back()->withInput($request->all);
			}

			// tendo ou não, passa pelo metodo de criar endereços
			$newEnderecos = new Endereco();
			$enderecos = $newEnderecos->UpdateEnderecoCliente($request, $idEnt);

			if(!$enderecos){
				return redirect()->back()->withInput($request->all);
			}

			// tendo ou não, passa pelo metodo de criar contatos
			$newContatos = new Contato();
			$contatos = $newContatos->UpdateContatoCliente($request, $idEnt);

			if(!$contatos){
				return redirect()->back()->withInput($request->all);
			}

			$newPlano = new Plano();
			$plano = $newPlano->UpdatePlanoCliente($request, $idPla);

			if(!$plano){
				return redirect()->back()->withInput($request->all);
			}

			$newCliente = new Cliente();
			$cliente = $newCliente->UpdateCliente($request, $idCli);

			if(!$cliente){
				return redirect()->back()->withInput($request->all);
			}else{
				$CodCliente = $cliente->codCliente;
			}

			$newLicense = new Licenses();
			$license = $newLicense->UpdateLicenseCliente($request, $CodCliente);

			if(!$license){
				return redirect()->back()->withInput($request->all);
			}
			// se ocorreu tudo bem, manda msg de sucesso e retorna.
			\Session::flash('mensagem',[
				'title'=> 'Licença',
				'msg'=> 'Cliente atualizado com sucesso !',
				'class'=> 'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=> 'sidenav-overlay-show'
				]);

			return redirect()->back()->withInput($request->all);
	}

	public function list()
	{
		$cliente = new Cliente();
		return $cliente->Listagem();
	}

	public function filter(Request $request)
	{
		$cliente = new Cliente();
		return $cliente->Filtro($request);
	}

	public function editar($idCli, $idEnt)
	{
		$return = true;

		$getCliente = new Cliente();
		$cliente = $getCliente->EditarCliente($idCli);

		if(!$cliente){
			$return = false;
		}

		$getEntidade = new Entidade();
		$entidade = $getEntidade->EditarEntidade($idEnt);

		if(!$entidade){
			$return = false;
		}

		$getEnderecos = new Endereco();
		$enderecos = $getEnderecos->EditarEnderecos($idEnt);

		$getContatos = new Contato();
		$contatos = $getContatos->EditarContatos($idEnt);

		$getPlano = new Plano();
		$plano = $getPlano->EditarPlanoCliente($cliente->idPlano);

		if(!$plano || empty($plano)){
			$return = false;
		}

		$getLicense = new Licenses();
		$license = $getLicense->EditarLicenseCliente($cliente->codCliente);

		if(!$license){
			$return = false;
		}

		if($return){
			return view('content.cliente.editar', compact('cliente', 'entidade', 'plano', 'license', 'enderecos', 'contatos'));
		}else{
			\Session::flash('mensagem',[
				'title'=> 'Ver Cliente',
				'msg'=> 'Não foi possivel achar este cliente (possivel problema: Cliente/Entidade/Plano ou licença). Verifique no email de suporte o erro.',
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			return redirect()->back();
		}
	}

	public function desativarEntidade($idEnt)
	{
		$cliente = new Cliente();
		$cliente = $cliente->DesativarCliente($idEnt);

		if($cliente){
			\Session::flash('mensagem',[
				'title'=> 'Licença',
				'msg'=> 'Cliente desativado com sucesso.',
				'class'=> 'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=> 'sidenav-overlay-show'
				]);
			return redirect('clientes');
		}
	}

	public function ativarEntidade($idEnt)
	{
		$cliente = new Cliente();
		$cliente = $cliente->AtivarCliente($idEnt);

		if($cliente){
			\Session::flash('mensagem',[
				'title'=> 'Licença',
				'msg'=> 'Cliente ativado com sucesso.',
				'class'=> 'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=> 'sidenav-overlay-show'
				]);
			return redirect()->back();
		}
	}

	public function deleteEntidade($idEnt)
	{
		$cliente = new Cliente();
		$cliente = $cliente->DeletarCliente($idEnt);

		if($cliente){
			\Session::flash('mensagem',[
				'title'=> 'Licença',
				'msg'=> 'Cliente deletado com sucesso.',
				'class'=> 'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=> 'sidenav-overlay-show'
				]);
			return redirect('clientes');
		}

	}

	public static function deleteContato(Request $request)
	{
		$contato = new Contato();
		return $contato->DeletarContatoPorId($request);
	}

	public static function deleteEndereco(Request $request)
	{
		$endereco = new Endereco();
		return $endereco->DeletarEnderecoPorId($request);
	}
}
