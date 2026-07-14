<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $roleName = $user->role?->nombre;

        //Supervisor: solo puede leer
        if ($roleName === 'Supervisor' && $request->isMethod('GET')) {
            return response()->json(['message' => 'Supervisor solo puede realizar consultas'], 403);
        }

        //Desarrollador: sin acceso a procesos de negocio
        if ($roleName === 'Desarrollador' && str_contains($request->path(), 'procesos')) {
            return response()->json(['message' => 'Desarrollador no tiene acceso a procesos de negocio'], 403);
        }

        //Verificar si el rol del usuario está en la lista de roles permitidos
        if (!empty($roles) && !in_array($roleName, $roles, true)) {
            return response()->json(['message' => 'No tiene permiso para esta accion.'], 403);
        }

        return $next($request);
    }
}
