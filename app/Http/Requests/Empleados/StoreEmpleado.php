<?php

namespace App\Http\Requests\Empleados;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpleado extends FormRequest
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

    public function rules()
    {
        return [
          'empleado_id' => 'required|string',
          'nombres' => 'required|string',
          'ap_paterno' => 'required|string',
          'ap_materno' => 'required|string',
          'ci' => 'required|string',
          'fecha_nac' => 'required|date',
          'lugar_nac' => 'required|string',
          'sexo' => 'required|string',
          'fecha_contrato' => 'required|date',
          'tipo_contrato' => 'required|string',
          'cargo_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
          'nombres.required' => 'El campo nombre es obligatorio',
          'fecha_nac.required' => 'El campo fecha de nacimiento es obligatorio',
          'fecha_contrato.required' => 'El campo fecha de contrato es obligatorio',
          'cargo_id.required' => 'El campo cargo es obligatorio',
          'ap_paterno.required' => 'El campo apellido paterno es obligatorio',
          'ap_materno.required' => 'El campo apellido materno es obligatorio',
        ];
    }
}
