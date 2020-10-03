<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Recebido as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\Emails;
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
	public function Plano()
	{
		return $this->belongsTo('App\Plano','idPlano');
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
}