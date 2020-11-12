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
			'msg'=> 'Novo cliente criado com sucesso ! Código do Cliente: <b>'. $license->codLicense .'</b> Crie o script na pasta do cliente e adicione o código dele.',
			'class'=> 'green white-text modal-show',
			'class-mc'=> 'green',
			'class-so'=> 'sidenav-overlay-show'
			]);

		// envia email de criacao do novo cliente
		// envia o obj cliente, entidade, licensa e o status
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
		$getCliente = new Cliente();
		$cliente = $getCliente->EditarCliente($idCli);

		if(!$cliente){
			return redirect()->back();
		}

		$getEntidade = new Entidade();
		$entidade = $getEntidade->EditarEntidade($idEnt);

		if(!$entidade){
			return redirect()->back();
		}

		$getEnderecos = new Endereco();
		$enderecos = $getEnderecos->EditarEnderecos($idEnt);

		// if(!$enderecos){
		// 	return redirect()->back();
		// }

		$getContatos = new Contato();
		$contatos = $getContatos->EditarContatos($idEnt);

		// if(!$contatos){
		// 	return redirect()->back();
		// }

		$getPlano = new Plano();
		$plano = $getPlano->EditarPlanoCliente($cliente->idPlano);

		// if(!$plano){
		// 	return redirect()->back();
		// }

		$getLicense = new Licenses();
		$license = $getLicense->EditarLicenseCliente($cliente->codCliente);

		// if(!$license){
		// 	return redirect()->back();
		// }

		return view('content.cliente.editar', compact('cliente', 'entidade', 'plano', 'license', 'enderecos', 'contatos'));
	}

	public function desativarEntidade($idEnt)
	{
		$entidade = new Entidade();
		$entidade = $entidade->DesativarEntidade($idEnt);

		if($entidade != 'true'){
			return $entidade;
		}

		$cliente = new Cliente();
		$cliente = $cliente->DesativarCliente($idEnt);

		if(!isset($cliente->idCliente)){
			return $cliente;
		}

		$contato = new Contato();
		$contato = $contato->DesativarContatos($idEnt);

		if($contato != 'true'){
			return $contato;
		}

		$endereco = new Endereco();
		$endereco = $endereco->DesativarEnderecos($idEnt);

		if($endereco != 'true'){
			return $endereco;
		}

		$plano = new Plano();
		$plano = $plano->DesativarPlano($cliente->idPlano);

		if($plano != 'true'){
			return $plano;
		}

		$license = new Licenses();
		return $license->DesativarLicenseCliente($cliente->codCliente);
	}

	public function ativarEntidade($idEnt)
	{
		$entidade = new Entidade();
		$entidade = $entidade->AtivarEntidade($idEnt);

		if($entidade != 'true'){
			return $entidade;
		}

		$cliente = new Cliente();
		$cliente = $cliente->AtivarCliente($idEnt);

		if(!isset($cliente->idCliente)){
			return $cliente;
		}

		$contato = new Contato();
		$contato = $contato->AtivarContatos($idEnt);

		if($contato != 'true'){
			return $contato;
		}

		$endereco = new Endereco();
		$endereco = $endereco->AtivarEnderecos($idEnt);

		if($endereco != 'true'){
			return $endereco;
		}

		$plano = new Plano();
		$plano = $plano->AtivarPlano($cliente->idPlano);

		if($plano != 'true'){
			return $plano;
		}

		$license = new Licenses();
		return $license->AtivarLicenseCliente($cliente->codCliente);

	}

	public function deleteEntidade($idEnt)
	{
		$entidade = new Entidade();
		$entidade = $entidade->DeletarEntidade($idEnt);

		if($entidade != 'true'){
			return $entidade;
		}

		$cliente = new Cliente();
		$cliente = $cliente->DeletarCliente($idEnt);

		if(!isset($cliente->idCliente)){
			return $cliente;
		}

		$contato = new Contato();
		$contato = $contato->DeletarContatos($idEnt);

		if($contato != 'true'){
			return $contato;
		}

		$endereco = new Endereco();
		$endereco = $endereco->DeletarEnderecos($idEnt);

		if($endereco != 'true'){
			return $endereco;
		}

		$plano = new Plano();
		$plano = $plano->DeletarPlano($cliente->idPlano);

		if($plano != 'true'){
			return $plano;
		}

		$license = new Licenses();
		return $license->DeletarLicenseCliente($cliente->codCliente);

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
