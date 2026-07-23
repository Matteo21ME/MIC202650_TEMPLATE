<?php

namespace Modules\MicroBusiness\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEspecialidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nombre' => ['sometimes', 'required', 'string', 'max:50', "unique:microbusiness.especialidades,nombre,{$id}"],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe una especialidad registrada con ese nombre.',
        ];
    }
}
