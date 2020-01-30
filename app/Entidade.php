<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Entidade as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Entidade extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
}
