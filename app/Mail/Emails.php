<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class Emails extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($tipo, $method, $error, $date)
	{
		//
		$this->tipo = $tipo;
		$this->method = $method;
		$this->error = $error;
		if($date === 'now'){
			$this->date = Carbon::now()->translatedFormat('Y j F, l, g:i a');
		}else{
			$this->date = $date;
		}
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('contato@agenciapublikando.com.br')
		->subject('Sistema Central informa: Error')
		->view('email.error.layout')
		->with([
			'TipoError' => $this->tipo,
			'MethodTarget' => $this->method,
			'MessageError' => $this->error,
			'DateError' => $this->date
		])
		;
		// exemplo de como chamar na funcao
		// Mail::to(\Config::get('mail.from.address'))->send(new Emails("Criar","CreateSegmento",$e->getMessage(),'now'));
	}
}