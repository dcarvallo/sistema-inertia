<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class ResetPassword extends FormRequest
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
    public function passes($attribute, $value)

    {
        return Hash::check($value, auth()->user()->password);
    }

    public function rules()
    {
      
        return [
          'actual' => ['required', new MatchOldPassword],
          'nuevo' => 'required|string|min:6',
          'nuevo_confirmation' => 'required|min:6|string|same:nuevo',
        ];
    }

    public function messages()
    {
        return [
            'nuevo_confirmation.same' => 'Las contraseñas no coinciden',
            'nuevo_confirmation.min' => 'Debe contener al menos 6 caracteres',
            'nuevo.min' => 'Debe contener al menos 6 caracteres',
            
        ];
    }
}
