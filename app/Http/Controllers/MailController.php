<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\License as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\MailClient;

class MailController extends Controller
{
	// Request $request
	public function sendMailClient($request)
	{
		$data = urldecode($request);

		parse_str($data, $output);

		$name = $output['name'];
		$contact = $output['contact'];
		$email = $output['email'];
		$message = $output['message'];

		$title = $output['title'];
		$subject = $output['subject'];
		$emailDestinatario = $output['emailDestinatario'];

		Mail::to($emailDestinatario)->send(new MailClient($message, $email, $contact, $name, $emailDestinatario, $subject, $title));
	}
}