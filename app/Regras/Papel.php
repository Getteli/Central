<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Papel as Authenticatable;

class Papel extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, Notifiable;
    
    protected $table = "papers";

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

    // criar um codigo unico
    static function CreateCod()
    {
        $_this = new self;
        $cod = $_this->getToken(4);
        return (string) $cod;
    }

    private function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    private function getToken($length)
    {
        $_this = new self;

        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$_this->crypto_rand_secure(0, $max-1)];
        }

        return $token;
    }

}