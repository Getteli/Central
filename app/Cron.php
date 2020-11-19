<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\License as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\EntidadeRequest;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Servicos\FormasPagamento;
use Illuminate\Http\Request;
use App\Mail\DeadlineMail;
use App\Entidades\Cliente;
use App\Licenses;
use App\Mail\Emails;

class Cron{

  // diminuir todo o dia as meia noite, 1 dia da licença do cliente que esteja apto.
  public function CronLessDay()
  {
    try{
      $gocount = false; // diminuir o dia se for true
      // pegue todos os clientes aptos
      $clientes = Cliente::where([['ativo','=',1]])
      ->Where(function ($query) {
        $query->where('deletado','=',0)
        ->orWhere('deletado','=',null);
      })->get();

      if($clientes->count() > 0){
        foreach($clientes as $cliente){
          $plano = $cliente->Plano;
          $licenca = Licenses::where('codCliente', '=', $cliente->codCliente)->first();

          $mesAnoCad = date('Y/m', strtotime($plano->created_at));
          $mesAnoAtual = date('Y/m');
          $diaAtual = date('d');
          $mesAnoMais = date('Y/m', strtotime("+2 months", strtotime($plano->created_at)));

          // echo $mesAnoMais . " (". $mesAnoCad .")";
          // echo "<br>";

          // o primerio mes é gratis. entao se o mes/ano de cadastro for igual ao mes atual, não conta.
          if($mesAnoCad == $mesAnoAtual)
          {
            // echo "1° mes gratis<br>";
            continue;
          }
          else
          {
            // se for do segundo mes para cima
            if($mesAnoAtual >= $mesAnoMais)
            {
              // echo "2 meses ou mais<br>";
              $gocount = true;
            }
            // se for apenas o primeiro mes
            else
            {
              // echo "1°mes p/ contar<br>";
              if($diaAtual >= $plano->dataPagamento){
                // echo "passou do dia de pagamento, pode diminuir<br>";
                $gocount = true;
              }
            }
            // echo "<hr>";
          }

          if($gocount){
            // verifica o tipo, se é especial ou qual for o outro motivo.
            switch ($licenca->special) {
              case '0': // cliente padrao
                $licenca->dias = $licenca->dias - 1;
                break;
              case '2': // promoção, verificar as datas
                break;
              case '4': // outro
                  break;
            }
            // atualiza a licença do cliente
            $licenca->update();
          }
        }
      }else{
        throw new \Exception("Não há clientes para diminuir os dias da licença.");
      }
    }catch(\Exception $e){
      // envia email pro suporte
      Mail::to(\Config::get('mail.from.address'))->send(new Emails("Cron","CronLessDay",$e->getMessage(),'now'));
    }
  }

  // verifica depois do lessDay se tem cliente a 5 dias ou menos, para enviar email lembrando de pagar
  public function CronVerifyPayment()
  {
    try{
      // pegue todos os clientes aptos a pagar
      $clientes = Cliente::where([['ativo','=',1]])
      ->Where(function ($query) {
        $query->where('deletado','=',0)
        ->orWhere('deletado','=',null);
      })->get();

      if($clientes->count() > 0){
        foreach($clientes as $cliente){
          $entidade = $cliente->Entidade;
          $licenca = Licenses::where('codCliente', '=', $cliente->codCliente)->first();
          // se for menor que 5 dias envia email informando que está perto de expirar sua linceça
          if($licenca->dias <= 5){
            $dias = $licenca->dias < 0 ? 0 : $licenca->dias;
            // enviar email
            Mail::to($entidade->email)->send(new DeadlineMail($cliente, $entidade, $licenca, $dias));
          }
        }
      }else{
        throw new \Exception("Não há clientes para verificar a licença.");
      }
    }catch(\Exception $e){
      // envia email pro suporte
      Mail::to(\Config::get('mail.from.address'))->send(new Emails("Cron","CronVerifyPayment",$e->getMessage(),'now'));
    }
  }
}
