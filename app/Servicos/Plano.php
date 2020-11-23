<?php

namespace App\Servicos;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Plano as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EntidadeRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Emails;
use App\Cliente;
use App\Entidade;
use App\Endereco;
use App\Contato;
use App\Licenses;

class Plano extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "planos";
	protected $primaryKey = 'idPlano';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Preco',
		'FormaPagamento',
		'DataPagamento',
		'Descricao',
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

	protected $guarded = ['idPlano', 'created_at', 'update_at'];

	// NAVIGATION
	public function Cliente()
	{
		return $this->hasMany('App\Entidades\Cliente','idPlano');
	}

	// METODOS
	public function Listagem()
	{
		try{
			$valorTotal = 0;
			$planos = Plano::where('ativo','=', 1)->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})->get();

			foreach ($planos as $key => $value) {
				$valorTotal += $value['preco'];
			}
			return view('content.plano.planos',compact('planos','valorTotal'));
		}catch(\Exception $e){;

			\Session::flash('mensagem',[
				'title'=> 'Planos',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Exibir","Listagem",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function Filtro(Request $request)
	{
		try{
			$filtrar = $request->all();

			$valorTotal = 0;

			// cria o objeto para a busca
			$planos = new Plano();

			// busca do usuario
			if (isset($filtrar['texto'])) {
				$planos = $planos->Where(function ($query) use($filtrar) {
					$query->where('descricao','LIKE','%'. $filtrar['texto'] .'%');
				});
			}
			if (isset($filtrar['preco'])) {
				$planos = $planos->where('preco','<=',$filtrar['preco']);
			}
			if (isset($filtrar['formaPagamento'])) {
				$planos = $planos->where('formaPagamento','=',$filtrar['formaPagamento']);
			}

			//padrao, buscar o que nao pode ser deletado E pega tudo em array
			$planos = $planos->Where(function ($query) {
				$query->where('deletado', '=', 0)
				->orWhere('deletado','=',null)
				->orWhere('deletado','!=',1);
			});
			$planos = $planos->get();

			foreach ($planos as $key => $value) {
				$valorTotal += $value['preco'];
			}

			if ($planos->isEmpty() || $planos->count() == 0) {
				\Session::flash('resultado',['msg'=>'Sem resultados !']);
			}else{
				\Session::flash('resultado', null);
			}

			return view('content.plano.planos',compact('planos','filtrar','valorTotal'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Planos',
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

	public function EditarPlano($idPlano)
	{
		try{

			$cliente = Cliente::where('idPlano','=',$idPlano)->first();

			$entidade = Entidade::find($cliente->idEntidade);

			$enderecos = Endereco::where('idEntidade', '=', $cliente->idEntidade)->where('ativo', '=', 1)->get();

			if(!$enderecos){
				 $enderecos = null;
			}

			$contatos = Contato::where('idEntidade', '=', $cliente->idEntidade)->where('ativo', '=', 1)->get();

			if(!$contatos){
				$contatos = null;
			}

			$license = Licenses::where('codCliente', '=', $cliente->codCliente)->where('ativo', '=', 1)->first();

			if(!$license){
				 $license = null;
			}

			if(isset($cliente->idPlano)){
				$plano = Plano::find($cliente->idPlano);
			}else{
				$plano = null;
			}
			return view('content.cliente.editar', compact('cliente', 'entidade', 'plano', 'license', 'enderecos', 'contatos'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Planos',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarPlano",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->route('clientes');
		}
	}

	public function CreatePlanoCliente(EntidadeRequest $request)
	{
		try{
			$dados = $request->all();

			// criar o plano desse cliente
			$plano = new Plano();
			$plano->descricao = $dados['descricao'];
			$plano->ativo = true;
			$plano->formaPagamento = $dados['formaPagamentoPlano'];
			$plano->preco = $dados['preco'];
			$plano->dataPagamento = $dados['dataPagamentoPlano'];
			$plano->save();

			return $plano;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Planos',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreatePlanoCliente",$e->getMessage(),'now'));
			return false;
		}
	}

	public function UpdatePlanoCliente(EntidadeRequest $request, $idPlanoCliente)
	{
		try{
			$dados = $request->all();

			// atualiza o plano desse cliente
			$plano = Plano::find($idPlanoCliente);
			$plano->descricao = $dados['descricao'];
			$plano->ativo = true;
			$plano->formaPagamento = $dados['formaPagamentoPlano'];
			$plano->preco = $dados['preco'];

			// se a data de pagamento nao tiver alterado, nao faz nada
			if($plano->dataPagamento != $dados['dataPagamentoPlano']){
				// so faz toda essa mudanca, se nao for mais o primeiro mes

				// aux
				$mesAnoCad = date('Y/m', strtotime($plano->created_at));
				$mesAnoAtual = date('Y/m');
				$mesAnoMais = date('Y/m', strtotime("+2 months", strtotime($plano->created_at)));

				// se for 1° mes, entao ainda esta gratuito, nao muda nada só a data msm.
				if($mesAnoCad != $mesAnoAtual){
					// pega o cliente pelo plano e pega a sua licenca
					$license = Licenses::where('codCliente', '=', $plano->Cliente->first()->codCliente)->first();
					// pega o numero de dias alterado
					$result = $plano->dataPagamento - $dados['dataPagamentoPlano'];
					// add esse resultado aos dias restantes
					$license->dias = $license->dias - $result;
				}
				// atualiza o dia de pagamento na licenca e no plano
				$license->dataLicense = $dados['dataPagamentoPlano'];
				$plano->dataPagamento = $dados['dataPagamentoPlano'];
				// atualiza a licenca
				$license->update();
			}
			// finaliza e atualiza
			$plano->update();

			return true;
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Planos',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdatePlanoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function EditarPlanoCliente($idPlano)
	{
		try{
			if(isset($idPlano)){
				$plano = Plano::where([['idPlano','=',$idPlano],
				['ativo','=',1]])
				->Where(function ($query) {
					$query->where('deletado','=',0)
					->orWhere('deletado','=',null);
				})
				->first();
			}else{
				$plano = null;
			}
			return $plano;

		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Planos',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarPlanoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	// public function DesativarPlano($idPlano)
	// {
	// 	try{
	// 		$plano = Plano::find($idPlano);
	// 		$plano->ativo = false;
	// 		$plano->update();
	//
	// 		return 'true';
	// 	}catch(\Exception $e){
	// 		\Session::flash('mensagem',[
	// 			'title'=> 'Planos',
	// 			'msg'=> $e->getMessage(),
	// 			'class'=> 'red white-text modal-show',
	// 			'class-mc'=> 'red',
	// 			'class-so'=> 'sidenav-overlay-show'
	// 			]);
	// 		// envia email de erro
	// 		Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarPlano",$e->getMessage(),'now'));
	// 		// retorna ao cliente
	// 		return redirect()->back();
	// 	}
	// }

	// public function AtivarPlano($idPlano)
	// {
	// 	try{
	// 		$plano = Plano::find($idPlano);
	// 		$plano->ativo = true;
	// 		$plano->update();
	//
	// 		return 'true';
	// 	}catch(\Exception $e){
	// 		\Session::flash('mensagem',[
	// 			'title'=> 'Planos',
	// 			'msg'=> $e->getMessage(),
	// 			'class'=> 'red white-text modal-show',
	// 			'class-mc'=> 'red',
	// 			'class-so'=> 'sidenav-overlay-show'
	// 			]);
	// 		// envia email de erro
	// 		Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarPlano",$e->getMessage(),'now'));
	// 		// retorna ao cliente
	// 		return redirect()->back();
	// 	}
	// }

	// public function DeletarPlano($idPlano)
	// {
	// 	try{
	// 		$plano = Plano::find($idPlano);
	// 		$plano->ativo = false;
	// 		$plano->deletado = true;
	// 		$plano->update();
	//
	// 		return 'true';
	// 	}catch(\Exception $e){
	// 		\Session::flash('mensagem',[
	// 			'title'=> 'Planos',
	// 			'msg'=> $e->getMessage(),
	// 			'class'=> 'red white-text modal-show',
	// 			'class-mc'=> 'red',
	// 			'class-so'=> 'sidenav-overlay-show'
	// 			]);
	// 		// envia email de erro
	// 		Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarPlano",$e->getMessage(),'now'));
	// 		// retorna ao cliente
	// 		return redirect()->back();
	// 	}
	// }
}
