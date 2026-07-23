<?php

namespace Modules\MicroBusiness\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'especialidad_id'  => ['sometimes', 'required', 'integer', 'exists:microbusiness.especialidades,id'],
            'cedula'           => ['sometimes', 'required', 'string', 'max:10', "unique:microbusiness.medicos,cedula,{$id}"],
            'nombre'           => ['sometimes', 'required', 'string', 'max:50'],
            'apellido'         => ['sometimes', 'required', 'string', 'max:50'],
            'correo'           => ['sometimes', 'required', 'email', 'max:100', "unique:microbusiness.medicos,correo,{$id}"],
        ];
    }

    public function messages(): array
    {
        return [
            'cedula.unique' => 'Ya existe un medico registrado con esa cedula.',
            'correo.unique' => 'Ya existe un medico registrado con ese correo.',
        ];
    }
}
