<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Endereco as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntidadeRequest;
use App\Exceptions\Handler;
use App\Mail\Emails;

class Endereco extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "enderecos";
	protected $primaryKey = 'idEndereco';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Numero',
		'Descricao',
		'Estado',
		'Cidade',
		'Logradouro',
		'Bairro',
		'Cep',
		'Complemento',
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

	protected $guarded = ['idEndereco', 'created_at', 'update_at'];

	// NAVIGATION
	public function Entidade()
	{
		return $this->belongsTo('App\Entidade','idEntidade');
	}

	// METODO

	public function CreateEnderecoCliente(EntidadeRequest $request, $idEntidadeCliente)
	{
		try{
			$dados = $request->all();

			// passa os dados do formulario de endereco
			$arrayE = array_filter($dados["enderecoForm"]);
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

				// verifica se algum dos campos importantes estao vazios
				if(
					!isset($arrayInterno['cep'])
					|| !isset($arrayInterno['logradouro'])
					|| !isset($arrayInterno['numero'])
					|| !isset($arrayInterno['estado'])
					|| !isset($arrayInterno['cidade'])
					|| !isset($arrayInterno['bairro'])
				){
					return;
					break;
				}

				$endereco = new Endereco();
				$endereco->cep = isset($arrayInterno['cep']) ? $arrayInterno['cep'] : null;
				$endereco->logradouro = isset($arrayInterno['logradouro']) ? $arrayInterno['logradouro'] : null;
				$endereco->numero = isset($arrayInterno['numero']) ? $arrayInterno['numero'] : null;
				$endereco->complemento = isset($arrayInterno['complemento']) ? $arrayInterno['complemento'] : null;
				$endereco->estado = isset($arrayInterno['estado']) ? $arrayInterno['estado'] : null;
				$endereco->cidade = isset($arrayInterno['cidade']) ? $arrayInterno['cidade'] : null;
				$endereco->bairro = isset($arrayInterno['bairro']) ? $arrayInterno['bairro'] : null;
				$endereco->descricao = isset($arrayInterno['descricaoEndereco']) ? $arrayInterno['descricaoEndereco'] : null;
				$endereco->idEntidade = $idEntidadeCliente;
				$endereco->ativo = true;
				$endereco->save();
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
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateEnderecoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function UpdateEnderecoCliente(EntidadeRequest $request, $idEntidadeCliente)
	{
		try{
			$dados = $request->all();

			// passa os dados do formulario de endereco
			$arrayE = array_filter($dados["enderecoForm"]);
			// array que guardará cada endereco
			$endereco = array();
			// verificar se tem valor para registrar endereco
			$enderecoBanco = Endereco::where('idEntidade', '=', $idEntidadeCliente)->where('ativo', '=', 1)->get();
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
				// verifica se algum dos campos importantes estao vazios
				if(
					!isset($arrayInterno['cep'])
					|| !isset($arrayInterno['logradouro'])
					|| !isset($arrayInterno['numero'])
					|| !isset($arrayInterno['estado'])
					|| !isset($arrayInterno['cidade'])
					|| !isset($arrayInterno['bairro'])
				){
					return;
					break;
				}

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
					$NovoEndereco->idEntidade = $idEntidadeCliente;
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
						$NovoEndereco->idEntidade = $idEntidadeCliente;
						$NovoEndereco->ativo = true;
						$NovoEndereco->save();
					}
					break;
				}
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
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateEnderecoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function EditarEnderecos($idEntidade)
	{
		try{
			$enderecos = Endereco::where([['idEntidade','=',$idEntidade],
			['ativo','=',1]])
			->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})
			->get();
			if($enderecos->isEmpty() || $enderecos->count() == 0){
				$enderecos = null;
			}
			return $enderecos;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Clientes',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarEnderecos",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function DesativarEnderecos($idEntidade)
	{
		try{
			$enderecos = Endereco::where("idEntidade","=",$idEntidade)->get();
			foreach ($enderecos as $key => $endereco) {
				$endereco->ativo = false;
				$endereco->update();
			}

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
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarEnderecos",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function AtivarEnderecos($idEntidade)
	{
		try{
			$enderecos = Endereco::where("idEntidade","=",$idEntidade)->get();
			foreach ($enderecos as $key => $endereco) {
				$endereco->ativo = true;
				$endereco->update();
			}

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
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarEnderecos",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function DeletarEnderecos($idEntidade)
	{
		try{
			$enderecos = Endereco::where("idEntidade","=",$idEntidade)->get();
			foreach ($enderecos as $key => $endereco) {
				$endereco->ativo = false;
				$endereco->deletado = true;
				$endereco->update();
			}

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
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarEnderecos",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function DeletarEnderecoPorId(Request $request)
	{
		try {
			$idEndereco = $request->idEndereco;

			$endereco = Endereco::find($idEndereco);
			$endereco->ativo = false;
			$endereco->deletado = true;
			$endereco->update();
			
			if ($endereco) {
				return "deletado com sucesso";
			}
		} catch (\Exception $e) {
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarEnderecoPorId",$e->getMessage(),'now'));
			// retorna ao cliente
			return $e;
		}
	}
}