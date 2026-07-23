<?php

namespace Modules\MicroBusiness\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $connection = 'microbusiness';

    protected $fillable = [
        'piso',
        'estado',
        'direccion',
    ];

    public function citasMedicas()
    {
        return $this->hasMany(CitaMedica::class);
    }
}