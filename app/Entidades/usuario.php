<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Usuario as Authenticatable;

class usuario extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, Notifiable;

    protected $table = "usuarios";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Funcao',
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