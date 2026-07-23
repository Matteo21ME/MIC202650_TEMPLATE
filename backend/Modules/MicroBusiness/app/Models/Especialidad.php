<?php

namespace Modules\MicroBusiness\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $connection = 'microbusiness';

    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}