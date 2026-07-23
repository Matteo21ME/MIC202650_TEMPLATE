<?php

use Illuminate\Support\Facades\Route;
use Modules\MicroAuth\Http\Controllers\AuthController;
use Modules\MicroAuth\Http\Controllers\RoleController;
use Modules\MicroAuth\Http\Controllers\UserController;

/*
 * MicroAuth API — versión 1
 * Prefijo base: /api  (el RouteServiceProvider del módulo lo registra bajo /api)
 */
Route::prefix('v1')->group(function () {

    // ── Autenticación pública ─────────────────────────────────────────────────
    Route::post('/auth/login', [AuthController::class, 'login']);

    // ── Rutas protegidas ──────────────────────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me',     [AuthController::class, 'me']);

        // Consulta: Administrador, Desarrollador y Supervisor
        Route::middleware('role:Administrador,Desarrollador,Supervisor')->group(function () {
            Route::get('/roles',             [RoleController::class, 'index']);
            Route::get('/usuarios',          [UserController::class, 'index']);
            Route::get('/usuarios/{id}',     [UserController::class, 'show']);
        });

        // Escritura: solo Administrador
        Route::middleware('role:Administrador')->group(function () {
            Route::post('/usuarios',         [UserController::class, 'store']);
            Route::put('/usuarios/{id}',     [UserController::class, 'update']);
            Route::delete('/usuarios/{id}',  [UserController::class, 'destroy']);
        });
    });
});
