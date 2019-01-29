<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
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
    $rules = [
      'ds_nome' => 'required|max:30|unique:tb_perfil',
    ];

    // Se formulário for de editar muda a regra de validação
		if ( in_array('PUT',$this->route()->methods) ) {
      $id = $this->route()->parameter('perfi');
      $rules['ds_nome'] = "required|max:30|unique:tb_perfil,ds_nome,{$id},co_seq_perfil";
    }

    return $rules;
  }

  /**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'ds_nome' => 'Nome'
		];
	}
}
