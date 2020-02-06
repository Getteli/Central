<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\License as Authenticatable;

class Licenses extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, Notifiable;

    // Definimos a conexão para o banco de license para este model
    protected $connection = 'mysql_two';

    protected $table = "licenses";

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
}
