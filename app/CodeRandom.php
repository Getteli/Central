<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeRandom extends Model
{
    // criar um codigo unico escolhendo a quantidade de digitos
    static function CreateCod($number)
    {
        $_this = new self;
        $cod = $_this->getToken($number);
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

    // criar um codigo de licença
    static function CreateCodLicense($codCli)
    {
        $_this = new self;
        //data
        $dt = new DateTime('NOW');
        $dt = $dt->format('YmdHis');
        $codR = $_this->CreateCod(20);

        return $CodLicense = $dt . $codR . $codCli;
    }
}