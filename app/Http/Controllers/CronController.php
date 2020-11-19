<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cron;

class CronController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Cron p/ diminuir os dias da licença
    public function CronLessDay()
    {
      $cron = new Cron();
      echo $cron->CronLessDay();
    }

    // cron p/ verificar todos os usuarios e os seus dias de licença para enviar email de pagamento
    public function CronVerifyPayment()
    {
      $cron = new Cron();
      echo $cron->CronVerifyPayment();
    }
}
