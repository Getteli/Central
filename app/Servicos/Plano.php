<?php

namespace App;

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
		return $this->hasMany('App\Cliente','idPlano');
	}

	// METODOS
	public function Listagem()
	{
		try{
			$valorTotal = 0;
			$planos = Plano::all()->where('ativo', 1)->where('desativado', 0);

			foreach ($planos as $key => $value) {
				$valorTotal += $value['preco'];
			}
			return view('content.plano.planos',compact('planos','valorTotal'));
		}catch(\Exception $e){;
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
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
				\Session::flash('mensagem',['msg'=>'Sem resultados!','class'=>'green white-text']);
			}else{
				\Session::flash('mensagem', null);
			}

			return view('content.plano.planos',compact('planos','filtrar','valorTotal'));
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
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
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
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
			
			return $plano->idPlano;
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreatePlanoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
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
			$plano->dataPagamento = $dados['dataPagamentoPlano'];
			$plano->update();

			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdatePlanoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function EditarPlanoCliente($idPlano)
	{
		try{
			if(isset($idPlano)){
				$plano = Cliente::where([['idPlano','=',$idPlano],
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
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarPlanoCliente",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->with('isErrorPlano',1);
		}
	}

	public function DesativarPlano($idPlano)
	{
		try{
			$plano = Plano::find($idPlano);
			$plano->ativo = false;
			$plano->update();
			
			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","DesativarPlano",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function AtivarPlano($idPlano)
	{
		try{
			$plano = Plano::find($idPlano);
			$plano->ativo = true;
			$plano->update();

			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","AtivarPlano",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}

	public function DeletarPlano($idPlano)
	{
		try{
			$plano = Plano::find($idPlano);
			$plano->ativo = false;
			$plano->deletado = true;
			$plano->update();
			
			return 'true';
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","DeletarPlano",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back();
		}
	}
}