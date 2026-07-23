<?php

namespace Modules\MicroBusiness\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $connection = 'microbusiness';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'direccion',
        'correo',
        'telefono',
    ];

    public function citasMedicas()
    {
        return $this->hasMany(CitaMedica::class);
    }

    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class);
    }
}