<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'funcao'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $guarded = ['id', 'created_at', 'update_at'];

	// pegar a sua relacao com a entidade
	public function entidade()
	{
		return $this->belongsToMany(Entidade::class);
	}

	// add um papel
	public function adicionaPapel($papel)
	{
		if(is_string($papel)){
			return $this->papeis()->save(
					Papel::where('nome','=',$papel)->firstOrFail()
				);
		}
		return $this->papeis()->save(
				Papel::where('nome','=',$papel->nome)->firstOrFail()
			);
	}

	// remover papel
	public function removePapel($papel)
	{
		if(is_string($papel)){
			return $this->papeis()->detach(
					Papel::where('nome','=',$papel)->firstOrFail()
				);
		}
		return $this->papeis()->detach(
				Papel::where('nome','=',$papel->nome)->firstOrFail()
			);
	}

	// verifica se existe um papel
	public function existePapel($papel)
	{
		if(is_string($papel)){
			return $this->papeis->contains('nome',$papel);
		}

		return $papel->intersect($this->papeis)->count();
	}

	// se for admin
	public function existeAdmin()
	{
		return $this->existePapel('admin');
	}
}