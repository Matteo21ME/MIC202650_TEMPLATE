<?php

use Illuminate\Support\Facades\Route;
use Modules\MicroBusiness\Http\Controllers\MicroBusinessController;

/*
 * MicroBusiness API — versión 1
 * Todas las rutas de negocio requieren autenticación con Sanctum.
 * Agrega aquí tus CRUDs: pacientes, citas, médicos, etc.
 */
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Ejemplo de endpoint de salud del módulo
    Route::get('/business/status', [MicroBusinessController::class, 'status']);

    // Agrega tus recursos aquí, por ejemplo:
    // Route::apiResource('pacientes', PacienteController::class);
    // Route::apiResource('medicos',   MedicoController::class);
    // Route::apiResource('citas',     CitaController::class);
});
