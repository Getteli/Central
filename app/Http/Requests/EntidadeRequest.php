<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntidadeRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'primeiroNome'=>'required',
			'email'=>'required',
			'apelido'=>'required',
			//'pages'=>'required|numeric'
		];
	}

	public function messages()
	{
		return [
			'primeiroNome.required' => 'É necessário colocar o primeiro nome.',
			'email.required' => 'É necessário colocar um Email válido.',
			'apelido.required' => 'É necessário colocar um apelido.',
			//'pages.numeric'  => 'Coloque números para as páginas.',
		];
	}
}
