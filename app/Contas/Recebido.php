<?php

namespace App\Contas;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Recebido as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests\RecebidoRequest;
use App\Mail\Emails;
use App\Entidades\Cliente;
use Carbon\Carbon;

class Recebido extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "recebidos";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Valor',
		'Descricao',
		'DataEntrada',
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

	protected $guarded = ['idRecebido', 'created_at', 'update_at'];

	// NAVIGATION
	public function Recebido()
	{
		return $this->belongsTo('App\Recebido','idRecebido');
	}

	public function CreateRecebido($request)
	{
		try{
			$dados = $request;

			// entao cria o cliente
			$recebido = new Recebido();
			$recebido->valor = $dados['preco'];
			$recebido->dataEntrada = date("Y-m-d"); // na hr que esta criando
			$recebido->descricao = $dados['descricao'];
			$recebido->ativo = true;
			$recebido->idPlano = $dados['idPlano'];
			$recebido->save();

			return true;
		}catch(\Exception $e){
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateRecebido",$e->getMessage(),'now'));
			// retorna ao cliente
			return false;
		}
	}

	public function Listagem()
	{
		try{
			$valorTotal = 0;
			$recebidos = Recebido::all()->where('ativo', 1)->where('desativado', 0);

			foreach ($recebidos as $key => $value) {
				$valorTotal += $value['valor'];
			}
			return view('content.recebido.recebidos',compact('recebidos','valorTotal'));
		}catch(\Exception $e){;

			\Session::flash('mensagem',[
				'title'=> 'Recebidos',
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

			$valorTotal = 0;

			// cria o objeto para a busca
			$recebidos = new Recebido();

			// busca do usuario
			if (isset($filtrar['texto'])) {
				$recebidos = $recebidos->Where(function ($query) use($filtrar) {
					$query->where('descricao','LIKE','%'. $filtrar['texto'] .'%');
				});
			}
			if (isset($filtrar['preco'])) {
				$recebidos = $recebidos->where('valor','<=',$filtrar['preco']);
			}

			if (isset($filtrar['idp']))
			{
				$recebidos = $recebidos->where('idPlano','=',$filtrar['idp']);
			}

			if(isset($filtrar['dataini']) && isset($filtrar['datafim']))
			{
				$recebidos = $recebidos->whereBetween('DataEntrada', [$filtrar['dataini'], $filtrar['datafim']]);
			}else if(isset($filtrar['dataini']))
			{
				$recebidos = $recebidos->where('DataEntrada', '>=',$filtrar['dataini']);
			}else if (isset($filtrar['datafim']))
			{
				$recebidos = $recebidos->where('DataEntrada', '<=',$filtrar['datafim']);
			}

			//padrao, buscar o que nao pode ser deletado E pega tudo em array
			$recebidos = $recebidos->Where(function ($query) {
				$query->where('deletado', '=', 0)
				->orWhere('deletado','=',null)
				->orWhere('deletado','!=',1);
			});
			$recebidos = $recebidos->get();

			foreach ($recebidos as $key => $value) {
				$valorTotal += $value['valor'];
			}

			if ($recebidos->isEmpty() || $recebidos->count() == 0) {
				\Session::flash('resultado',['msg'=>'Sem resultados !']);
			}else{
				\Session::flash('resultado', null);
			}

			return view('content.recebido.recebidos',compact('recebidos','filtrar','valorTotal'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Recebidos',
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

	public function VerCliente($idPlano)
	{
		$cliente = Cliente::Where('idPlano','=',$idPlano)->first();

		if(!is_null($cliente)){
			return redirect()->route('cliente.editar',[$cliente->idCliente, $cliente->idEntidade]);
			// echo $cliente->idEntidade;
		}else{
			return redirect()->back();
		}
	}

	public function Adicionar(RecebidoRequest $request)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$recebido = new Recebido();
			$recebido->descricao = $dados['descricao'];
			$recebido->valor = $dados['valor'];
			$recebido->dataEntrada = $dados['dataEntrada'];
			$recebido->ativo = true;
			$recebido->save();

			\Session::flash('mensagem',[
				'title'=> 'Recebido',
				'msg'=>'Recebido externo criado com sucesso !',
				'class'=>'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=>'sidenav-overlay-show'
				]);

			return redirect()->back()->withInput($request->all);
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Recebido',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","AdicionarRecebido",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}
}
