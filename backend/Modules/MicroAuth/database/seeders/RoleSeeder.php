<?php

namespace Modules\MicroAuth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\MicroAuth\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(['nombre' => 'Administrador'], ['descripcion' => 'Acceso total DDL y DML']);
        Role::updateOrCreate(['nombre' => 'Desarrollador'], ['descripcion' => 'Consultas, vistas y optimizacion sin datos sensibles']);
        Role::updateOrCreate(['nombre' => 'Supervisor'],    ['descripcion' => 'Solo lectura SELECT y vistas']);
        Role::updateOrCreate(['nombre' => 'Usuario'],       ['descripcion' => 'Solo lectura SELECT']);
    }
}
