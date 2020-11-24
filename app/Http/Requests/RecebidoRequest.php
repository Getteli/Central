<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecebidoRequest extends FormRequest
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
			'valor'=>'required',
			'descricao'=>'required',
			'dataEntrada'=>'required',
			//'pages'=>'required|numeric'
		];
	}

	public function messages()
	{
		return [
			'descricao.required' => 'É necessário colocar uma descrição sobre este recebido.',
			'valor.required' => 'É necessário colocar um valor ao recebido.',
			'dataEntrada.required' => 'É necessário colocar a data de entrada deste recebido.',
			//'pages.numeric'  => 'Coloque números para as páginas.',
		];
	}
}
