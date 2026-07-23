<?php

namespace Modules\MicroBusiness\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $connection = 'microbusiness';

    protected $fillable = [
        'medico_id',
        'Dia_Semana',
        'hora_inicio',
        'hora_fin',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}