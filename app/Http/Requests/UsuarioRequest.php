<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
    $input = $this->all();

    $rules = [
      'ds_nome'=>'required|max:120',
      'email'=>'required|email|unique:tb_usuario',
			'password' => 'required|min:6|confirmed',
			'img_profile' => 'image|nullable',
			'roles' => 'array|nullable'
    ];

    // Se formulário for de editar muda a regra de validação
    if ( in_array('PUT',$this->route()->methods) ) {
      $id = $this->route()->parameter('usuario');
      $rules['email'] = "required|email|unique:tb_usuario,email,{$id},co_seq_usuario";
    }

    // Campo senha opcional na tela de editar
    if ( in_array('PUT',$this->route()->methods) && empty($input['password']) ) {
      unset($rules['password']);
    }

		return $rules;
	}
}
