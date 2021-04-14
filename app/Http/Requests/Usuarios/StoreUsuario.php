<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      // return $this->user()->can('users create');
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
          'nombres' => 'required|string',
          'apellidos' => 'required|string',
          'imagen' => 'image|nullable',
          'username' => 'required|string',
          'email' => 'required|string|email',
          'password' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El campo nombre de usuario es obligatorio',
        ];
    }
}
