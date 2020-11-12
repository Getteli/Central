<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Entidades\Cliente;
use App\Entidades\Entidade;
use App\Licenses;
use Carbon\Carbon;
use App\Servicos\FormasPagamento;

class WelcomeMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Cliente $cliente, Entidade $entidade, Licenses $licensecliente)
	{
		//
		$this->cliente = $cliente;
		$this->entidade = $entidade;
		$this->license = $licensecliente;
		//Carbon::now()->translatedFormat('Y j F, l, g:i a');
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('contato@agenciapublikando.com.br')
		->subject('Publikando: Bem vindo !')
		->view('email.default.welcome')
		->with([
			'codCliente' => $this->cliente->codCliente,
			'entidadeEmail' => $this->entidade->email,
			'nomeCliente' => $this->entidade->primeiroNome,
			'codLicense' => $this->license->codLicense,
			'servicoPrestado' => $this->cliente->Plano->descricao,
			'valor' => $this->cliente->Plano->preco,
			'date' => $this->cliente->Plano->dataPagamento,
			'formaPag' => FormasPagamento::getNameFPagamento($this->cliente->Plano->formaPagamento),
			'obs' => $this->license->observacao,
		])
		;
	}
}
