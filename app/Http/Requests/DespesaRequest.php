<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DespesaRequest extends FormRequest
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
			'dataPagamento'=>'required',
			//'pages'=>'required|numeric'
		];
	}

	public function messages()
	{
		return [
			'descricao.required' => 'É necessário colocar uma descrição sobre este despesa.',
			'valor.required' => 'É necessário colocar um valor ao despesa.',
			'dataPagamento.required' => 'É necessário colocar a data de entrada deste despesa.',
			//'pages.numeric'  => 'Coloque números para as páginas.',
		];
	}
}
