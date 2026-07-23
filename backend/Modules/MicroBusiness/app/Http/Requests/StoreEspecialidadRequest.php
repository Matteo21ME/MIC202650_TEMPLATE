<?php

namespace Modules\MicroBusiness\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEspecialidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50', 'unique:microbusiness.especialidades,nombre'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe una especialidad registrada con ese nombre.',
        ];
    }
}