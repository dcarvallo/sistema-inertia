<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuario extends FormRequest
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
          'nombres' => 'required|string',
          'apellidos' => 'required|string',
          'imagen' => 'image|nullable',
          'username' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El campo nombre de usuario es obligatorio',
        ];
    }
}
