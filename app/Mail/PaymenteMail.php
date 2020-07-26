<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Cliente;
use App\Entidade;

class PaymenteMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Cliente $cliente, Entidade $entidade)
	{
		//
		$this->cliente = $cliente;
		$this->entidade = $entidade;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('contato@agenciapublikando.com.br')
		->view('email.default.payment')
		->with([
			'codCliente' => $this->cliente->codCliente,
			'entidadeEmail' => $this->entidade->email,
		])
		;
	}
}