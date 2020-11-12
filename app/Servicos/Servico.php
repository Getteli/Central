<?php

namespace App\Servicos;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use App\Http\Requests\ServicoRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Servico as Authenticatable;
use App\Mail\Emails;

class Servico extends Authenticatable implements MustVerifyEmailContract
{
	use MustVerifyEmail, Notifiable;

	protected $table = "servicos";
	protected $primaryKey = 'idServico';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'Servico',
		'Descricao',
		'Ativo',
		'Deletado',
		'Preco',
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

	protected $guarded = ['idServico', 'created_at', 'update_at'];

	// NAVIGATION
	public function Segmento()
	{
		return $this->belongsTo('App\Segmento','idSegmento');
	}

	// METODOS

	public function CreateServico(ServicoRequest $request)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$servico = new Servico();
			$servico->servico = $dados['servico'];
			$servico->descricao = $dados['descricao'];
			$servico->idSegmento = $dados['idSegmento'];
			$servico->preco = $dados['preco'];
			$servico->ativo = true;
			$servico->save();

			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=>'Novo serviço criado com sucesso !',
				'class'=>'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=>'sidenav-overlay-show'				
				]);

			return redirect()->back()->withInput($request->all);
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateServico",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function UpdateServico(ServicoRequest $request, $idServ)
	{
		try{
			$dados = $request->all();

			// cria a entidade
			$servico = Servico::find($idServ);
			$servico->servico = $dados['servico'];
			$servico->descricao = $dados['descricao'];
			$servico->idSegmento = $dados['idSegmento'];
			$servico->preco = $dados['preco'];
			$servico->update();

			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> 'Serviço atualizado com sucesso !',
				'class'=> 'green white-text modal-show',
				'class-mc'=> 'green',
				'class-so'=> 'sidenav-overlay-show'
				]);

			return redirect()->route('servicos');
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Atualizar","UpdateServico",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function Listagem(Type $var = null)
	{
		try{
			$servicos = Servico::all()->where('ativo', 1)->where('desativado', 0);
			return view('content.servico.servicos',compact('servicos'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
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

			// cria o objeto para a busca
			$servicos = new Servico;

			// busca do usuario
			if (isset($filtrar['texto'])) {
				$servicos = $servicos->Where(function ($query) use($filtrar) {
					$query->where('servico','LIKE','%'. $filtrar['texto'] .'%')
					->orWhere('descricao','LIKE','%'. $filtrar['texto'] .'%');
				});
			}
			if (isset($filtrar['status'])) {
				$servicos = $servicos->where('ativo','=',$filtrar['status']);
			}
			if (isset($filtrar['segmento'])) {
				$servicos = $servicos->where('idSegmento','=',$filtrar['segmento']);
			}

			//padrao, buscar o que nao pode ser deletado E pega tudo em array
			$servicos = $servicos->Where(function ($query) {
				$query->where('deletado', '=', 0)
				->orWhere('deletado','=',null)
				->orWhere('deletado','!=',1);
			});
			$servicos = $servicos->get();

			if ($servicos->isEmpty() || $servicos->count() == 0) {
				\Session::flash('resultado',['msg'=>'Sem resultados !']);
			}else{
				\Session::flash('resultado', null);
			}

			return view('content.servico.servicos',compact('servicos','filtrar'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
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

	public function Editar($idServ)
	{
		try{
			$servico = Servico::find($idServ);
			
			return view('content.servico.editar', compact('servico'));
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Editar","Editar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}
	}

	public function Desativar($idServ)
	{
		try {
			$servico = Servico::find($idServ);
			$servico->ativo = false;
			$servico->update();

			if ($servico) {
				\Session::flash('mensagem',[
					'title'=> 'Serviços',
					'msg'=> 'Serviço desativado com sucesso.',
					'class'=> 'green white-text modal-show',
					'class-mc'=> 'green',
					'class-so'=> 'sidenav-overlay-show'
					]);
				return redirect()->route('servicos');
			}
		}catch(\Exception $e) {
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Desativar","Desativar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput();
		}
	}

	public function Ativar($idServ)
	{
		try {
			$servico = Servico::find($idServ);
			$servico->ativo = true;
			$servico->update();

			if ($servico) {
				\Session::flash('mensagem',[
					'title'=> 'Serviços',
					'msg'=> 'Serviço ativado com sucesso.',
					'class'=> 'green white-text modal-show',
					'class-mc'=> 'green',
					'class-so'=> 'sidenav-overlay-show'
					]);
				return redirect()->route('servicos');
			}
		}catch(\Exception $e) {
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Ativar","Ativar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput();
		}
	}

	public function Deletar($idServ)
	{
		try {
			$servico = Servico::find($idServ);
			$servico->ativo = false;
			$servico->deletado = true;
			$servico->update();

			if ($servico) {
				\Session::flash('mensagem',[
					'title'=> 'Serviços',
					'msg'=> 'Serviço deletado com sucesso.',
					'class'=> 'green white-text modal-show',
					'class-mc'=> 'green',
					'class-so'=> 'sidenav-overlay-show'
					]);
				return redirect()->route('servicos');
			}
		}catch(\Exception $e) {
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Deletar","Deletar",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput();
		}
	}

	public function ListagemComSegmento(Request $request)
	{
		try{
			$idSegmento = $request->idSegmento; // id a pesquisar do segmento
			$arrayServicos = array(); // array que armazenará
			$i = 0; // contador

			foreach ( Servico::Where('idSegmento','=', $idSegmento)->get() as $Servico) {
				$arrayServicos[$i]['preco'] = $Servico['preco'];
				$arrayServicos[$i]['servico'] = $Servico['servico'];
				$i++; // incrementa
			}

			// retorna o array encapsulado como um json para o javascript
			return json_encode($arrayServicos);
		}catch(\Exception $e){
			\Session::flash('mensagem',[
				'title'=> 'Serviços',
				'msg'=> $e->getMessage(),
				'class'=> 'red white-text modal-show',
				'class-mc'=> 'red',
				'class-so'=> 'sidenav-overlay-show'
				]);
			// envia email de erro
			Mail::to(\Config::get('mail.from.address'))->send(new Emails("Exibir","ListagemComSegmento",$e->getMessage(),'now'));
			// retorna ao cliente
			return redirect()->back()->withInput($request->all);
		}

		// CASO FOR USAR ESTA FUNCAO DE LISTAGEM, SEGUE O EXEMPLO
		/*
	document.getElementById("idSegmento").addEventListener("change", function(){
		// manda o token como cabecalho
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			}
		});
		$.ajax({
			url: "{{ route('servico.ListagemComSegmento') }}",
			type: "POST",
			data: {
				'idSegmento': this.value
			},
			success: function(response){
				// converte em objeto o resultado do php
				var obj = jQuery.parseJSON(response);
				// pega o select pelo id
				var selectList = document.getElementById("idServico");

				// remove todas as opções anteriores
				for (i = selectList.length - 1; i >= 0; i--) {
					// se for o option padrao de selecione, nao o remova
					if (selectList.options[i].value != -1) {
						selectList.remove(i);
					}
				}

				// popula o select com o resultado do php
				for(var k in obj) {
					var option = document.createElement("option");
					option.value = obj[k]['preco'];
					option.text = obj[k]['servico'];
					selectList.appendChild(option);
				}

				// atualiza o select do materialize para renderizar no DOM
				$('select').formSelect();
			},
			error: function(response){
				// se der erro, não faça nada
			}
		});
	});
	
		*/
	}
}