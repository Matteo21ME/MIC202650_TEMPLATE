<?php

namespace Modules\MicroBusiness\Http\Services;

use Modules\MicroBusiness\Models\CitaMedica;
use Illuminate\Database\Eloquent\Collection;

class CitaMedicaService
{
    public function getAll(): Collection
    {
        return CitaMedica::with(['paciente', 'medico', 'consultorio'])->get();
    }

    public function getById(int $id): CitaMedica
    {
        return CitaMedica::with(['paciente', 'medico', 'consultorio'])->findOrFail($id);
    }

    public function create(array $data): CitaMedica
    {
        return CitaMedica::create($data);
    }

    public function update(int $id, array $data): CitaMedica
    {
        $citaMedica = CitaMedica::findOrFail($id);
        $citaMedica->update($data);
        return $citaMedica->fresh();
    }

    public function delete(int $id): void
    {
        CitaMedica::findOrFail($id)->delete();
    }
}