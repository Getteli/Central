<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Segmento as Authenticatable;
use App\Http\Requests\SegmentoRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Emails;

class Segmento extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "segmentos";
	protected $primaryKey = 'idSegmento';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Segmento',
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

	protected $guarded = ['idSegmento', 'created_at', 'update_at'];

	// NAVIGATION
	public function Servico()
	{
		return $this->hasMany('App\Servico','idSegmento');
	}

	// METODOS
	public function CreateSegmento(SegmentoRequest $request)
	{
		try{
			$dados = $request->all();

			// cria o segmento
			$segmento = new Segmento();
			$segmento->segmento = $dados['segmento'];
			$segmento->descricao = $dados['descricao'];
			$segmento->ativo = true;
			$segmento->save();

			\Session::flash('mensagem',['msg'=>'Novo segmento criado com sucesso!','class'=>'green white-text']);
			return redirect()->back()->withInput($request->all);

		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>'Erro ao adicionar o novo Segmento, verifique com o suporte.','class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateSegmento",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}


	public function UpdateSegmento(SegmentoRequest $request, $idSeg)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$segmento = Segmento::find($idSeg);
			$segmento->segmento = $dados['segmento'];
			$segmento->descricao = $dados['descricao'];
			$segmento->update();

			\Session::flash('mensagem',['msg'=>'Cliente atualizado com sucesso!','class'=>'green white-text']);
			
			return redirect()->back()->withInput($request->all);
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateSegmento",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function Listagem()
	{
		try{
			$segmentos = Segmento::all()->where('ativo', 1)->where('desativado', 0);
			return view('content.segmento.segmentos',compact('segmentos'));
		}catch(\Exception $e){
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

			// cria o objeto para a busca
			$segmentos = new Segmento;

			// busca do usuario
			if (isset($filtrar['texto'])) {
				$segmentos = $segmentos->Where(function ($query) use($filtrar) {
					$query->where('segmento','LIKE','%'. $filtrar['texto'] .'%')
					->orWhere('descricao','LIKE','%'. $filtrar['texto'] .'%');
				});
			}
			if (isset($filtrar['status'])) {
				$segmentos = $segmentos->where('ativo','=',$filtrar['status']);
			}

			//padrao, buscar o que nao pode ser deletado E pega tudo em array
			$segmentos = $segmentos->Where(function ($query) {
				$query->where('deletado', '=', 0)
				->orWhere('deletado','=',null)
				->orWhere('deletado','!=',1);
			});
			$segmentos = $segmentos->get();

			if ($segmentos->isEmpty() || $segmentos->count() == 0) {
				\Session::flash('mensagem',['msg'=>'Sem resultados!','class'=>'green white-text']);
			}else{
				\Session::flash('mensagem', null);
			}

			return view('content.segmento.segmentos',compact('segmentos','filtrar'));
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("filtrar","Filtro",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function EditarSegmento($idSeg)
	{
		try{
			$segmento = Segmento::find($idSeg);
			return view('content.segmento.editar', compact('segmento'));
		}catch(\Exception $e){
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","EditarSegmento",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function Desativar($idSeg)
	{
		try {
			$segmento = Segmento::find($idSeg);
			$segmento->ativo = false;
			$segmento->update();

			$servicos = Servico::where("idSegmento","=",$segmento->idSegmento)->get();
			foreach ($servicos as $key => $servico) {
				$servico->ativo = false;
				$servico->update();
			}

			if ($segmento && $servicos) {
				\Session::flash('mensagem',['msg'=>'Segmento desativado com sucesso.','class'=>'green white-text']);
				return redirect()->back()->withInput();
			}
		}catch(\Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","Desativar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput();
		}
	}

	public function Ativar($idSeg)
	{
		try {
			$segmento = Segmento::find($idSeg);
			$segmento->ativo = true;
			$segmento->update();

			$servicos = Servico::where("idSegmento","=",$segmento->idSegmento)->get();
			foreach ($servicos as $key => $servico) {
				$servico->ativo = true;
				$servico->update();
			}

			if ($segmento && $servicos) {
				\Session::flash('mensagem',['msg'=>'Segmento ativado com sucesso.','class'=>'green white-text']);
				return redirect()->route('segmentos');
			}
		}catch(\Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","Ativar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput();
		}
	}

	public function Deletar($idSeg)
	{
		try {
			$segmento = Segmento::find($idSeg);
			$segmento->ativo = false;
			$segmento->deletado = true;
			$segmento->update();

			$servicos = Servico::where("idSegmento","=",$segmento->idSegmento)->get();
			foreach ($servicos as $key => $servico) {
				$servico->ativo = false;
				$servico->deletado = true;
				$servico->update();
			}

			if ($segmento && $servicos) {
				\Session::flash('mensagem',['msg'=>'Segmento deletado com sucesso.','class'=>'green white-text']);
				return redirect()->route('segmentos');
			}
		}catch(\Exception $e) {
			\Session::flash('mensagem',['msg'=>$e->getMessage(),'class'=>'red white-text']);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","Deletar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput();
		}
	}
}