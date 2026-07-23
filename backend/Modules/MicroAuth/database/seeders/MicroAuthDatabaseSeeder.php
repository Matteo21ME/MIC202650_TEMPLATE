<?php

namespace Modules\MicroAuth\Database\Seeders;

use Illuminate\Database\Seeder;

class MicroAuthDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
