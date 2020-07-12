<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SegmentoRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'segmento'=>'required',
			//'pages'=>'required|numeric'
		];
	}

	public function messages()
	{
		return [
			'segmento.required' => 'É necessário colocar um nome ao segmento.',
			//'pages.numeric'  => 'Coloque números para as páginas.',
		];
	}
}