<?php

namespace Modules\MicroBusiness\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultorioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'piso'      => ['required', 'string', 'max:50'],
            'estado'    => ['required', 'in:DISPONIBLE,MANTENIMIENTO,OCUPADO'],
            'direccion' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'piso.required' => 'El piso es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
        ];
    }
}