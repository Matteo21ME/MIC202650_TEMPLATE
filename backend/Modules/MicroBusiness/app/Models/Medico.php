<?php

namespace Modules\MicroBusiness\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $connection = 'microbusiness';

    protected $fillable = [
        'especialidad_id',
        'cedula',
        'nombre',
        'apellido',
        'correo',
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function citasMedicas()
    {
        return $this->hasMany(CitaMedica::class);
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class);
    }

    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class);
    }
}