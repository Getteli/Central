<?php

namespace App\Entidades;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Contato as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntidadeRequest;
use App\Mail\Emails;

class Contato extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "contatos";
	protected $primaryKey = 'idContato';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Identificacao',
		'Email',
		'Ddd',
		'Ativo',
		'Deletado',
		'Numero',
		'Ativo',
		'Deletado',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		//'password', 'Rg',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		//'email_verified_at' => 'datetime',
	];

	protected $guarded = ['idContato', 'created_at', 'update_at'];

	// NAVIGATION
	public function Entidade()
	{
		return $this->belongsTo('App\Entidade','idEntidade');
	}

	// METODOS

	public function CreateContatoCliente(EntidadeRequest $request, $idEntidadeCliente)
	{
		try{
			$dados = $request->all();

			// passa os dados do formulario de contato
			$array = array_filter($dados["contatoForm"]);
			if(!$array){
				return;
			}
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
				$contato->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] != "Personalizado" ? $arrayInterno['identificacao'] : $arrayInterno['identificacaoManual'] : null;
				$contato->idEntidade = $idEntidadeCliente;
				$contato->ativo = true;
				$contato->save();
				break;
			}
			return true;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateContatoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function UpdateContatoCliente(EntidadeRequest $request, $idEntidadeCliente)
	{
		try{
			$dados = $request->all();

			// passa os dados do formulario de contato
			$array = array_filter($dados["contatoForm"]);
			if(!$array){
				return;
			}
			// array que guardará cada contato
			$contato = array();
			// verificar se tem valor para registrar contato
			$contatoBanco = Contato::where('idEntidade', '=', $idEntidadeCliente)->get();
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
					$NovoContato->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] != "Personalizado" ? $arrayInterno['identificacao'] : $arrayInterno['identificacaoManual'] : null;
					$NovoContato->idEntidade = $idEntidadeCliente;
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
						$contatoBanco[$k]->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] != "Personalizado" ? $arrayInterno['identificacao'] : $arrayInterno['identificacaoManual'] : null;
						$contatoBanco[$k]->update();
					}else{
						$NovoContato = new Contato();
						$NovoContato->ddd = isset($arrayInterno['ddd']) ? $arrayInterno['ddd'] : null;
						$NovoContato->numero = isset($arrayInterno['numeroContato']) ? $arrayInterno['numeroContato'] : null;
						$NovoContato->Email = isset($arrayInterno['emailContato']) ? $arrayInterno['emailContato'] : null;
						$NovoContato->identificacao = isset($arrayInterno['identificacao']) ? $arrayInterno['identificacao'] != "Personalizado" ? $arrayInterno['identificacao'] : $arrayInterno['identificacaoManual'] : null;
						$NovoContato->idEntidade = $idEntidadeCliente;
						$NovoContato->ativo = true;
						$NovoContato->save();
					}
					break;
				}
			}
			return true;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'atualizar cliente',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateContatoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function EditarContatos($idEntidade)
	{
		try{
			$contatos = Contato::where([['idEntidade','=',$idEntidade],
			['ativo','=',1]])
			->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})
			->get();
			if($contatos->isEmpty() || $contatos->count() == 0){
				$contatos = null;
			}
			return $contatos;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarContatos",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	// public function DesativarContatos($idEntidade)
	// {
	// 	try{
	// 		$contatos = Contato::where("idEntidade","=",$idEntidade)->get();
	// 		foreach ($contatos as $key => $contato) {
	// 			$contato->ativo = false;
	// 			$contato->update();
	// 		}
	//
	// 		return 'true';
	// 	}catch(\Exception $e){
	// 		\Session::flash('mensagem',[
	// 			'title'=> 'Clientes',
	// 			'msg'=> $e->getMessage(),
	// 			'class'=> 'red white-text modal-show',
	// 			'class-mc'=> 'red',
	// 			'class-so'=> 'sidenav-overlay-show'
	// 			]);
	// 		// envia email de erro
	// 		Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarContatos",$e->getMessage(),'now'));
	// 		// retorna ao cliente
	// 		return redirect()->back();
	// 	}
	// }

	// public function AtivarContatos($idEntidade)
	// {
	// 	try{
	// 		$contatos = Contato::where("idEntidade","=",$idEntidade)->get();
	// 		foreach ($contatos as $key => $contato) {
	// 			$contato->ativo = true;
	// 			$contato->update();
	// 		}
	//
	// 		return 'true';
	// 	}catch(\Exception $e){
	// 		\Session::flash('mensagem',[
	// 			'title'=> 'Clientes',
	// 			'msg'=> $e->getMessage(),
	// 			'class'=> 'red white-text modal-show',
	// 			'class-mc'=> 'red',
	// 			'class-so'=> 'sidenav-overlay-show'
	// 			]);
	// 		// envia email de erro
	// 		Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarContatos",$e->getMessage(),'now'));
	// 		// retorna ao cliente
	// 		return redirect()->back();
	// 	}
	// }

	// public function DeletarContatos($idEntidade)
	// {
	// 	try{
	// 		$contatos = Contato::where("idEntidade","=",$idEntidade)->get();
	// 		foreach ($contatos as $key => $contato) {
	// 			$contato->ativo = false;
	// 			$contato->deletado = true;
	// 			$contato->update();
	// 		}
	//
	// 		return 'true';
	// 	}catch(\Exception $e){
	// 		\Session::flash('mensagem',[
	// 			'title'=> 'Clientes',
	// 			'msg'=> $e->getMessage(),
	// 			'class'=> 'red white-text modal-show',
	// 			'class-mc'=> 'red',
	// 			'class-so'=> 'sidenav-overlay-show'
	// 			]);
	// 		// envia email de erro
	// 		Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarContatos",$e->getMessage(),'now'));
	// 		// retorna ao cliente
	// 		return redirect()->back();
	// 	}
	// }

	public function DeletarContatoPorId(Request $request)
	{
		try {
			$idContato = $request->idContato;

			$contato = Contato::find($idContato);
			$contato->ativo = false;
			$contato->deletado = true;
			$contato->update();

			if ($contato) {
				return "deletado com sucesso";
			}
		} catch (\Exception $e) {
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarContatoPorId",$e->getMessage(),'now'));
			// retorna ao cliente
			return $e;
		}
	}
}
