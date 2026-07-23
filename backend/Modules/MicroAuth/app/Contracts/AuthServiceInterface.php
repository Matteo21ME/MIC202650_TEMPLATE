<?php

namespace Modules\MicroAuth\Contracts;

/**
 * Contrato público de MicroAuth.
 * Otros módulos deben depender de esta interfaz,
 * NUNCA de los modelos internos (User, Role).
 */
interface AuthServiceInterface
{
    /**
     * Retorna datos públicos del usuario autenticado por ID.
     * @return array{id:int,name:string,email:string,role:string|null}|null
     */
    public function getUserById(int $id): ?array;

    /**
     * Verifica si un usuario tiene el rol indicado.
     */
    public function hasRole(int $userId, string $role): bool;

    /**
     * Retorna todos los roles disponibles.
     * @return array<int,array{id:int,nombre:string,descripcion:string|null}>
     */
    public function getRoles(): array;
}
