<?php

namespace Modules\MicroAuth\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'microauth';

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
