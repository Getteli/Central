<?php

namespace App\Regras;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Papel as Authenticatable;

class Papel extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, Notifiable;
    
    protected $table = "papers";
    protected $primaryKey = 'idPapel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Descricao',
        'CodPapel',
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

    // ver as permissoes ligada
    public function permissoes()
    {
    	return $this->belongsToMany(Permissao::class);
    }

    // add uma permissao
    public function adicionarPermissao($permissao)
    {
    	return $this->permissoes()->save($permissao);
    }

    // remover uma permissao
    public function removerPermissao($permissao)
    {
    	return $this->permissoes()->detach($permissao);
    }

}