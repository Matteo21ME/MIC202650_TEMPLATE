<?php

namespace Modules\MicroAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica que el usuario autenticado tenga uno de los roles permitidos.
     * También aplica restricciones de método por rol específico.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado.'], 401);
        }

        $roleName = $user->role?->nombre;

        // Supervisor: solo lectura (GET)
        if ($roleName === 'Supervisor' && !$request->isMethod('GET')) {
            return response()->json(['message' => 'Supervisor solo puede realizar consultas.'], 403);
        }

        // Desarrollador: sin acceso a pacientes ni citas medicas
        if (
            $roleName === 'Desarrollador'
            && ($request->is('api/v1/pacientes*') || $request->is('api/v1/citas-medicas*'))
        ) {
            return response()->json(['message' => 'Desarrollador no tiene acceso a pacientes ni citas medicas.'], 403);
        }

        // Verificar lista de roles permitidos para la ruta
        if (!empty($roles) && !in_array($roleName, $roles, true)) {
            return response()->json(['message' => 'No tiene permiso para esta accion.'], 403);
        }

        return $next($request);
    }
}
