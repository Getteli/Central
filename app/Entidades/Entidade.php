<?php

namespace App\Entidades;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Entidade as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EntidadeRequest;
use App\Entidades\Cliente;
use App\CodeRandom;
use App\Exceptions\Handler;
use App\Mail\Emails;

class Entidade extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "entidades";
	protected $primaryKey = 'idEntidade';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'PrimeiroNome',
		'Email',
		'SobreNome',
		'Apelido',
		'Password',
		'Nacionalidade',
		'DataExpedicao',
		'Sexo',
		'Rg',
		'OrgaoEmissor',
		'Cpf',
		'Naturalidade',
		'DataNascimento',
		'Ativo',
		'Deletado',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'Rg',
	];

	protected $guarded = ['idEntidade', 'created_at', 'update_at'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		//'email_verified_at' => 'datetime',
	];

	// NAVIGATION
	public function Cliente()
	{
		return $this->hasMany('App\Entidades\Cliente','idEntidade');
	}

	public function Contato()
	{
		return $this->hasMany('App\Entidades\Contato','idEntidade');
	}

	public function Endereco()
	{
		return $this->hasMany('App\Entidades\Endereco','idEntidade');
	}

	// METODO

	public function CreateEntidadeCliente(EntidadeRequest $request)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$entidade = new Entidade();
			$entidade->primeiroNome = $dados['primeiroNome'];
			$entidade->sobrenome = $dados['sobrenome'];
			$entidade->email = $dados['email'];
			$entidade->cpf = Hash::make($dados['cpf']);
			$entidade->rg = Hash::make($dados['rg']);
			$entidade->ativo = true;
			$entidade->orgaoEmissor = $dados['orgaoEmissor'];
			$entidade->dataExpedicao = $dados['dataExpedicao'];
			$entidade->dataNascimento = $dados['dataNascimento'];
			$entidade->apelido = $dados['apelido'];
			$entidade->sexo = $dados['sexo'];
			$entidade->naturalidade = $dados['naturalidade'];
			$entidade->nacionalidade = $dados['nacionalidade'];
			$entidade->save();

			// volta a chave para continuar a criacao da entidade Cliente
			return $entidade;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Criar um novo cliente',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateEntidadeCliente",$e->getMessage(),'now'));
			return false;
		}
	}

	public function UpdateEntidadeCliente(EntidadeRequest $request, $idEnt)
	{
		try{
			$dados = $request->all();

			// atualiza a entidade
			$entidade = Entidade::find($idEnt);
			$entidade->primeiroNome = $dados['primeiroNome'];
			$entidade->sobrenome = $dados['sobrenome'];
			$entidade->email = $dados['email'];
			// só atualiza se tiver add um novo
			if ($dados['cpf'] && $dados['cpf'] != null && $dados['cpf'] != "" && !empty($dados['cpf'])) {
				$entidade->cpf = Hash::make($dados['cpf']);
			}
			// só atualiza se tiver add um novo
			if ($dados['rg'] && $dados['rg'] != null && $dados['rg'] != "" && !empty($dados['rg'])) {
				$entidade->rg = Hash::make($dados['rg']);
			}
			$entidade->orgaoEmissor = $dados['orgaoEmissor'];
			$entidade->dataExpedicao = $dados['dataExpedicao'];
			$entidade->dataNascimento = $dados['dataNascimento'];
			$entidade->apelido = $dados['apelido'];
			$entidade->sexo = $dados['sexo'];
			$entidade->naturalidade = $dados['naturalidade'];
			$entidade->nacionalidade = $dados['nacionalidade'];
			$entidade->update();

			return true;

		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Atualizar cliente',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateEntidadeCliente",$e->getMessage(),'now'));
			return false;
		}
	}

	public function EditarEntidade($idEntidade)
	{
		try{
			$entidade = Entidade::where([['idEntidade','=',$idEntidade],
			['ativo','=',1]])
			->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})
			->first();
			if($entidade){
				return $entidade;
			}else{
				throw new \Exception("Entidade não encontrado ou não disponivel");
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
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarEntidade",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function DesativarEntidade($idEntidade)
	{
		try{
			$entidade = Entidade::find($idEntidade);
			$entidade->ativo = false;
			$entidade->update();

			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarEntidade",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function AtivarEntidade($idEntidade)
	{
		try{
			$entidade = Entidade::find($idEntidade);
			$entidade->ativo = true;
			$entidade->update();

			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarEntidade",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function DeletarEntidade($idEntidade)
	{
		try{
			$entidade = Entidade::find($idEntidade);
			$entidade->ativo = false;
			$entidade->deletado = true;
			$entidade->update();

			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarEntidade",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}
}
