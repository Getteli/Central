<?php

namespace App\Entidades;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Cliente as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EntidadeRequest;
use App\Entidades\Entidade;
use App\Entidades\Endereco;
use App\Entidades\Contato;
use App\Servicos\Plano;
use App\Licenses;
use App\CodeRandom;
use App\Exceptions\Handler;
use App\Mail\Emails;

class Cliente extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "clientes";
	protected $primaryKey = 'idCliente';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'DataPagamento',
		'CodCliente',
		'Cnpj',
		'Link',
		'RazaoSocial',
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

	protected $guarded = ['idCliente', 'created_at', 'update_at'];

	// NAVIGATION
	public function Entidade()
	{
		return $this->belongsTo('App\Entidades\Entidade','idEntidade');
	}

	public function Plano()
	{
		return $this->belongsTo('App\Servicos\Plano','idPlano');
	}

	// METODO

	public function CreateCliente(EntidadeRequest $request, $idPlanoCliente, $idEntidadeCliente)
	{
		try{
			$dados = $request->all();

			// entao cria o cliente
			$cliente = new Cliente();
			$cliente->codCliente = $this->GetCod();
			$cliente->cnpj = $dados['cnpj'];
			$cliente->razaoSocial = $dados['razaoSocial'];
			$cliente->dataPagamento = $dados['dataPagamentoPlano'];
			$cliente->link = $dados['link'];
			$cliente->ativo = true;
			$cliente->idPlano = $idPlanoCliente;
			$cliente->idEntidade = $idEntidadeCliente;
			$cliente->save();

			return $cliente;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateCliente",$e->getMessage(),'now'));

			return false;
		}
	}

	public function UpdateCliente(EntidadeRequest $request, $idCliente)
	{
		try{
			$dados = $request->all();

			// entao atualiza o cliente
			$cliente = Cliente::find($idCliente);
			$cliente->cnpj = $dados['cnpj'];
			$cliente->razaoSocial = $dados['razaoSocial'];
			$cliente->dataPagamento = $dados['dataPagamentoPlano'];
			$cliente->link = $dados['link'];
			$cliente->update();

			return $cliente;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function Listagem()
	{
		try{
			$clientes = Cliente::all()->where('ativo', 1)->where('deletado', 0);
			return view('content.cliente.clientes',compact('clientes'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Exibir","Listagem",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function Filtro(Request $request)
	{
		try{
			$filtrar = $request->all();

			// faz a busca do objeto com um join na entidade
			$clientes = Cliente::join('entidades', 'clientes.idEntidade', '=', 'entidades.idEntidade');

			// busca do usuario
			if (isset($filtrar['texto'])) {
				$clientes = $clientes->Where(function ($query) use($filtrar) {
					$query->where('codCliente','=',$filtrar['texto'])
					->orWhere('razaoSocial','LIKE','%'. $filtrar['texto'] .'%')
					->orWhere('primeiroNome','LIKE','%'. $filtrar['texto'] .'%')
					->orWhere('email','LIKE','%'. $filtrar['texto'] .'%')
					->orWhere('apelido','LIKE','%'. $filtrar['texto'] .'%')
					->orWhere('cnpj','=',$filtrar['texto']);
				});
			}
			if (isset($filtrar['status'])) {
				$clientes = $clientes->where('clientes.ativo','=',$filtrar['status']);
			}

			//padrao, buscar o que nao pode ser deletado E pega tudo em array
			$clientes = $clientes->Where(function ($query) {
				$query->where('clientes.deletado', '=', 0)
				->orWhere('clientes.deletado','=',null)
				->orWhere('clientes.deletado','!=',1);
			});
			$clientes = $clientes->get();

			if ($clientes->isEmpty() || $clientes->count() == 0) {
				\Session::flash('resultado',['msg'=>'Sem resultados !']);
			}else{
				\Session::flash('resultado', null);
			}

			return view('content.cliente.clientes',compact('clientes','filtrar'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Filtrar","Filtro",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function EditarCliente($idCliente)
	{
		try{
			$cliente = Cliente::where([['idCliente','=',$idCliente],
			['ativo','=',1]])
			->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})
			->first();
			if($cliente){
				return $cliente;
			}else{
				throw new \Exception("Cliente não encontrado ou não disponivel");
			}
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function DesativarCliente($idEntidade)
	{
		try{
			// OBS: Preferi desativar cada parte direto do cliente, para caso ocorra algum erro, o código não conclua
			// a desativação por parte.
			$queryAll = Cliente::join('entidades', 'clientes.idEntidade', '=', 'entidades.idEntidade')
			->join('planos', 'clientes.idPlano', '=', 'planos.idPlano')
	    ->leftjoin('enderecos', 'enderecos.idEntidade','=', 'entidades.idEntidade')
	    ->leftjoin('contatos', 'contatos.idEntidade', '=', 'entidades.idEntidade')
			->join('license.licenses', 'clientes.codCliente', '=', 'licenses.codCliente')
			->where('clientes.idEntidade','=',$idEntidade)
			->update(array(
				'entidades.ativo' => false,
				'clientes.ativo' => false,
				'planos.ativo' => false,
				'licenses.ativo' => false,
				'enderecos.ativo' => false,
				'contatos.ativo' => false
			));

			return true;
		} catch (\Exception $e) {
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function AtivarCliente($idEntidade)
	{
		try{
			// OBS: Preferi desativar cada parte direto do cliente, para caso ocorra algum erro, o código não conclua
			// a desativação por parte.
			$queryAll = Cliente::join('entidades', 'clientes.idEntidade', '=', 'entidades.idEntidade')
			->join('planos', 'clientes.idPlano', '=', 'planos.idPlano')
	    ->leftjoin('enderecos', 'enderecos.idEntidade','=', 'entidades.idEntidade')
	    ->leftjoin('contatos', 'contatos.idEntidade', '=', 'entidades.idEntidade')
			->join('license.licenses', 'clientes.codCliente', '=', 'licenses.codCliente')
			->where('clientes.idEntidade','=',$idEntidade)
			->update(array(
				'entidades.ativo' => true,
				'clientes.ativo' => true,
				'planos.ativo' => true,
				'licenses.ativo' => true,
				'enderecos.ativo' => true,
				'contatos.ativo' => true
			));

			return true;
		} catch (\Exception $e) {
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function DeletarCliente($idEntidade)
	{
		try{
			// OBS: Preferi deletar cada parte direto do cliente, para caso ocorra algum erro, o código não conclua
			// a exclusao por parte.
			$queryAll = Cliente::join('entidades', 'clientes.idEntidade', '=', 'entidades.idEntidade')
			->join('planos', 'clientes.idPlano', '=', 'planos.idPlano')
	    ->leftjoin('enderecos', 'enderecos.idEntidade','=', 'entidades.idEntidade')
	    ->leftjoin('contatos', 'contatos.idEntidade', '=', 'entidades.idEntidade')
			->join('license.licenses', 'clientes.codCliente', '=', 'licenses.codCliente')
			->where('clientes.idEntidade','=',$idEntidade)
			->update(array(
				'entidades.ativo' => false,
				'entidades.deletado' => true,

				'clientes.ativo' => false,
				'clientes.deletado' => true,

				'planos.ativo' => false,
				'planos.deletado' => true,

				'licenses.ativo' => false,
				'licenses.deletado' => true,

				'enderecos.ativo' => true,
				'enderecos.deletado' => true,

				'contatos.ativo' => false,
				'contatos.deletado' => true
			));

			return true;
		} catch (\Exception $e) {
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function GetCod(){
		$codP = new CodeRandom;
		$cod = $codP->CreateCod(5);
		return $cod;
	}
}
