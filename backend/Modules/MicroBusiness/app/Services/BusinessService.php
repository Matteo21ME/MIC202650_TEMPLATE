<?php

namespace Modules\MicroBusiness\Services;

use Modules\MicroAuth\Contracts\AuthServiceInterface;

/**
 * Ejemplo de servicio de negocio.
 * Inyecta el contrato de auth para verificar permisos sin acoplar al módulo de auth.
 */
class BusinessService
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    /**
     * Verifica si el usuario tiene el rol requerido antes de ejecutar lógica de negocio.
     */
    public function canPerformAction(int $userId, string $requiredRole): bool
    {
        return $this->authService->hasRole($userId, $requiredRole);
    }
}
