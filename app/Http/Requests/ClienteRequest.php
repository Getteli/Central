<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
			//'CodCliente'=>'required',
			//'pages'=>'required|numeric'
		];
	}

	public function messages()
	{
		return [
			//'CodCliente.required' => 'Teste request World CLiente',
			//'pages.numeric'  => 'Coloque números para as páginas.',
		];
	}
}