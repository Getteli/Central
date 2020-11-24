<?php

namespace App\Contas;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use App\Http\Requests\DespesaRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Despesa as Authenticatable;

class Despesa extends Authenticatable implements MustVerifyEmailContract
{
  use MustVerifyEmail, Notifiable;

  protected $table = "despesas";
  protected $primaryKey = 'idDespesa';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'Valor',
      'Descricao',
      'DataPagamento',
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

  public function Listagem()
	{
		try{
			$valorTotal = 0;
			$despesas = Despesa::where('ativo', 1)->Where(function ($query) {
				$query->where('deletado','=',0)
				->orWhere('deletado','=',null);
			})->get();

			foreach ($despesas as $key => $value) {
				$valorTotal += $value['valor'];
			}
			return view('content.despesa.despesas',compact('despesas','valorTotal'));
		}catch(\Exception $e){;

			\Session::flash('mensagem',[
				'title'=> 'Despesas',
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
			$despesas = new Despesa();

			// busca do usuario
			if (isset($filtrar['texto'])) {
				$despesas = $despesas->Where(function ($query) use($filtrar) {
					$query->where('descricao','LIKE','%'. $filtrar['texto'] .'%');
				});
			}
			if (isset($filtrar['preco'])) {
				$despesas = $despesas->where('valor','<=',$filtrar['preco']);
			}

			if(isset($filtrar['dataini']) && isset($filtrar['datafim']))
			{
				$despesas = $despesas->whereBetween('dataPagamento', [$filtrar['dataini'], $filtrar['datafim']]);
			}else if(isset($filtrar['dataini']))
			{
				$despesas = $despesas->where('dataPagamento', '>=',$filtrar['dataini']);
			}else if (isset($filtrar['datafim']))
			{
				$despesas = $despesas->where('dataPagamento', '<=',$filtrar['datafim']);
			}

			//padrao, buscar o que nao pode ser deletado E pega tudo em array
			$despesas = $despesas->Where(function ($query) {
				$query->where('deletado', '=', 0)
				->orWhere('deletado','=',null)
				->orWhere('deletado','!=',1);
			});
			$despesas = $despesas->get();

			foreach ($despesas as $key => $value) {
				$valorTotal += $value['valor'];
			}

			if ($despesas->isEmpty() || $despesas->count() == 0) {
				\Session::flash('resultado',['msg'=>'Sem resultados !']);
			}else{
				\Session::flash('resultado', null);
			}

			return view('content.despesa.despesas',compact('despesas','filtrar','valorTotal'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Despesas',
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


  	public function CreateDespesa(DespesaRequest $request)
  	{
  		try{
  			$dados = $request;

  			// entao cria o cliente
  			$despesa = new Despesa();
  			$despesa->valor = $dados['valor'];
  			$despesa->dataPagamento = $dados['dataPagamento']; // na hr que esta criando
  			$despesa->descricao = $dados['descricao'];
  			$despesa->ativo = true;
  			$despesa->save();

        \Session::flash('mensagem',[
  				'title'=> 'Despesas',
  				'msg'=>'Despesa adicionada com sucesso.',
  				'class'=>'green white-text modal-show',
  				'class-mc'=> 'green',
  				'class-so'=>'sidenav-overlay-show'
  				]);

  			return redirect()->back()->withInput($request->all);
  		}catch(\Exception $e){
        \Session::flash('mensagem',[
  				'title'=> 'Despesa',
  				'msg'=> $e->getMessage(),
  				'class'=> 'red white-text modal-show',
  				'class-mc'=> 'red',
  				'class-so'=> 'sidenav-overlay-show'
  				]);
  			// envia email de erro
  			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateDespesa",$e->getMessage(),'now'));
        // retorna ao cliente
        return redirect()->back()->withInput($request->all);
  		}
  	}

}
