<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntidadeRequest;
use App\Cliente;
use App\Entidade;
use App\Endereco;
use App\Contato;
use App\CodeRandom;
use App\Plano;
use App\Licenses;

class ClienteController extends Controller
{

	public function adicionar(EntidadeRequest $request)
	{

			// cria o objeto entidade para começar a criacao do cliente
			$entidade = new Entidade();
			$idEntidadeCliente = $entidade->CreateEntidadeCliente($request);

			if(!is_numeric($idEntidadeCliente)){
				return $idEntidadeCliente;
			}
			 
			// tendo ou não, passa peo metodo de criar endereços
			$enderecos = new Endereco();
			$enderecos = $enderecos->CreateEnderecoCliente($request, $idEntidadeCliente);

			if($enderecos != 'true'){
				return $enderecos;
			}

			// tendo ou não, passa peo metodo de criar contatos
			$contatos = new Contato();
			$contatos = $contatos->CreateContatoCliente($request, $idEntidadeCliente);

			if($contatos != 'true'){
				return $contatos;
			}

			$plano = new Plano();
			$idPlanoCliente = $plano->CreatePlanoCliente($request);

			if(!is_numeric($idPlanoCliente)){
				return $idPlanoCliente;
			}

			$cliente = new Cliente();
			$CodCliente = $cliente->CreateCliente($request, $idPlanoCliente, $idEntidadeCliente);

			if(!is_string($CodCliente)){
				return $CodCliente;
			}

			$license = new Licenses();
			return $license->CreateLicenseCliente($request, $CodCliente);
	}

	public function atualizar(EntidadeRequest $request, $idEnt, $idPla, $idCli)
	{
			// cria o objeto entidade para começar a criacao do cliente
			$entidade = new Entidade();
			$entidade = $entidade->UpdateEntidadeCliente($request, $idEnt);

			if($entidade != 'true'){
				return $entidade;
			}

			// tendo ou não, passa peo metodo de criar endereços
			$enderecos = new Endereco();
			$enderecos = $enderecos->UpdateEnderecoCliente($request, $idEnt);

			if($enderecos != 'true'){
				return $enderecos;
			}

			// tendo ou não, passa peo metodo de criar contatos
			$contatos = new Contato();
			$contatos = $contatos->UpdateContatoCliente($request, $idEnt);

			if($contatos != 'true'){
				return $contatos;
			}

			$plano = new Plano();
			$idPlanoCliente = $plano->UpdatePlanoCliente($request, $idPla);

			if($idPlanoCliente != 'true'){
				return $idPlanoCliente;
			}

			$cliente = new Cliente();
			$CodCliente = $cliente->UpdateCliente($request, $idCli);

			if(!is_string($CodCliente)){
				return $CodCliente;
			}

			$license = new Licenses();
			return $license->UpdateLicenseCliente($request, $CodCliente);
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
		$cliente = new Cliente();
		$cliente = $cliente->EditarCliente($idCli);

		if(!isset($cliente->idCliente)){
			return $cliente;
		}

		$entidade = new Entidade();
		$entidade = $entidade->EditarEntidade($idEnt);

		if(!isset($entidade->idEntidade)){
			return $entidade;
		}

		$enderecos = new Endereco();
		$enderecos = $enderecos->EditarEnderecos($idEnt);

		if(session('isErrorEnd')){
			return $enderecos;
		}

		$contatos = new Contato();
		$contatos = $contatos->EditarContatos($idEnt);

		if(session('isErrorCont')){
			return $contatos;
		}

		$plano = new Plano();
		$plano = $plano->EditarPlanoCliente($cliente->idPlano);

		if(session('isErrorPlano')){
			return $plano;
		}

		$license = new Licenses();
		$license = $license->EditarLicenseCliente($cliente->codCliente);

		if(session('isErrorL')){
			return $license;
		}

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