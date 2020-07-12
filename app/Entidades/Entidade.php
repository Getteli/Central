<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Entidade as Authenticatable;

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
		return $this->hasMany('App\Cliente','idEntidade');
	}

	public function Contato()
	{
		return $this->hasMany('App\Contato','idEntidade');
	}

	public function Endereco()
	{
		return $this->hasMany('App\Endereco','idEntidade');
	}
}