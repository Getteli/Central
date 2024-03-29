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

class PaymentMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Cliente $cliente, Entidade $entidade, Licenses $licensecliente, $status)
	{
		//
		$this->cliente = $cliente;
		$this->entidade = $entidade;
		$this->license = $licensecliente;
		$this->status = $status;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('contato@agenciapublikando.com.br')
		->subject('Publikando: Informações sobre a fatura.')
		->view('email.default.payment')
		->with([
			'codCliente' => $this->cliente->codCliente,
			'entidadeEmail' => $this->entidade->email,
			'nomeCliente' => $this->entidade->primeiroNome,
			'codLicense' => $this->license->codLicense,
			'servicoPrestado' => $this->cliente->Plano->descricao,
			'valor' => $this->cliente->Plano->preco,
			'formaPag' => FormasPagamento::getNameFPagamento($this->cliente->Plano->formaPagamento),
			'date' => $this->cliente->Plano->dataPagamento,
			'obs' => $this->license->observacao,
			'status' => $this->status,
		])
		;
	}
}
