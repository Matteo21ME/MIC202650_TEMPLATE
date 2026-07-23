<?php

namespace Modules\MicroBusiness\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $connection = 'microbusiness';

    protected $table = 'historias_clinicas';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'fecha_registro',
        'diagnostico',
        'tratamiento',
        'recetas',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}