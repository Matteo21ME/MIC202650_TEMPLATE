<?php

namespace Modules\MicroBusiness\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MicroAuth\Contracts\AuthServiceInterface;

/**
 * Ejemplo de controller de negocio que consume MicroAuth
 * a través del contrato, sin tocar modelos internos de auth.
 */
class MicroBusinessController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    /**
     * Estado del módulo + datos del usuario autenticado vía contrato de auth.
     */
    public function status(Request $request): JsonResponse
    {
        $userData = $this->authService->getUserById($request->user()->id);

        return response()->json([
            'module'  => 'MicroBusiness',
            'version' => 'v1',
            'status'  => 'active',
            'user'    => $userData,
        ]);
    }
}
