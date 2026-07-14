<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::where('nombre', 'Administrador')->first();
        $dev = Role::where('nombre', 'Desarrollador')->first();
        $supe = Role::where('nombre', 'Supervisor')->first();
        $user = Role::where('nombre', 'Usuario')->first();

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('admin123'), 'role_id' => $admin->id]
        );

        User::updateOrCreate(
            ['email' => 'dev@example.com'],
            ['name' => 'Developer', 'password' => Hash::make('dev123'), 'role_id' => $dev->id]
        );

        User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            ['name' => 'Supervisor', 'password' => Hash::make('supervisor123'), 'role_id' => $supe->id]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User', 'password' => Hash::make('user123'), 'role_id' => $user->id]
        );
    }
}
