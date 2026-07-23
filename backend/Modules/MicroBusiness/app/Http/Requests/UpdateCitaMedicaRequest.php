<?php

namespace Modules\MicroBusiness\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCitaMedicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medico_id'      => ['sometimes', 'required', 'integer', 'exists:microbusiness.medicos,id'],
            'paciente_id'    => ['sometimes', 'required', 'integer', 'exists:microbusiness.pacientes,id'],
            'consultorio_id' => ['sometimes', 'required', 'integer', 'exists:microbusiness.consultorios,id'],
            'Dia_Semana'     => ['sometimes', 'required', 'string', 'in:Lunes,Martes,Miércoles,Jueves,Viernes'],
            'hora'           => ['sometimes', 'required', 'regex:/^([01]\\d|2[0-3]):[0-5]\\d(:[0-5]\\d)?$/'],
            'motivo'         => ['sometimes', 'required', 'string', 'max:255'],
            'estado'         => ['sometimes', 'required', 'string', 'in:PROGRAMADA,ATENDIDA,CANCELADA'],
        ];
    }

    public function messages(): array
    {
        return [
            'consultorio_id.unique' => 'Ya existe una cita médica registrada con ese consultorio.',
            'Dia_Semana.required' => 'El día de la semana es obligatorio.',
            'hora.required' => 'La hora es obligatoria.',
            'motivo.required' => 'El motivo es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
        ];
    }
}