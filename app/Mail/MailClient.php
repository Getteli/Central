<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class MailClient extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($message, $email, $contact, $name, $emailDestinatario, $subject, $title)
	{
		//
		$this->message = $message;
		$this->email = $email;
		$this->contact = $contact;
		$this->name = $name;
		$this->emailDestinatario = $emailDestinatario;
		$this->subject = $subject;
		$this->title = $title;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from('seusite@agenciapublikando.com.br', $this->title)
		->replyTo($this->email, $this->name)
		->subject($this->subject)
		->view('email.client.layout')
		->with([
			'TitleSMC' => $this->title,
			'MessageSMC' => $this->message,
			'ContactSMC' => $this->contact,
			'NameSMC' => $this->name,
			'EmailSMC' => $this->email,
		])
		;
	}
}