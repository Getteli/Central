<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicoRequest extends FormRequest
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
			'servico'=>'required',
			'preco'=>'required',
			'idSegmento'=>'required',
			//'pages'=>'required|numeric'
		];
	}

	public function messages()
	{
		return [
			'servico.required' => 'É necessário colocar um nome ao serviço.',
			'preco.required' => 'É necessário colocar um preço ao serviço.',
			'idSegmento.required' => 'É necessário colocar um segmento a este serviço.',
			//'pages.numeric'  => 'Coloque números para as páginas.',
		];
	}
}