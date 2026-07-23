<?php

namespace Modules\MicroAuth\Services;

use Modules\MicroAuth\Contracts\AuthServiceInterface;
use Modules\MicroAuth\Models\User;
use Modules\MicroAuth\Models\Role;

/**
 * Implementación de AuthServiceInterface.
 * Los demás módulos inyectan la interfaz, no esta clase.
 */
class AuthService implements AuthServiceInterface
{
    public function getUserById(int $id): ?array
    {
        $user = User::with('role')->find($id);

        if (!$user) {
            return null;
        }

        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role?->nombre,
        ];
    }

    public function hasRole(int $userId, string $role): bool
    {
        $user = User::with('role')->find($userId);
        return $user?->hasRole($role) ?? false;
    }

    public function getRoles(): array
    {
        return Role::orderBy('nombre')
            ->get(['id', 'nombre', 'descripcion'])
            ->toArray();
    }
}
