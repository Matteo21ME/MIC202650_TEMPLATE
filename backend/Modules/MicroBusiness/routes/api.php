<?php

use Illuminate\Support\Facades\Route;
use Modules\MicroBusiness\Http\Controllers\CitaMedicaController;
use Modules\MicroBusiness\Http\Controllers\ConsultorioController;
use Modules\MicroBusiness\Http\Controllers\EspecialidadController;
use Modules\MicroBusiness\Http\Controllers\MedicoController;
use Modules\MicroBusiness\Http\Controllers\MicroBusinessController;
use Modules\MicroBusiness\Http\Controllers\PacienteController;

/*
 * MicroBusiness API — versión 1
 * Todas las rutas de negocio requieren autenticación con Sanctum.
 * Agrega aquí tus CRUDs: pacientes, citas, médicos, etc.
 */
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Ejemplo de endpoint de salud del módulo
    Route::get('/business/status', [MicroBusinessController::class, 'status']);

    // Consulta general
    Route::middleware('role:Administrador,Desarrollador,Supervisor')->group(function () {
        Route::apiResource('medicos', MedicoController::class)->only(['index', 'show']);
        Route::apiResource('especialidades', EspecialidadController::class)->only(['index', 'show']);
        Route::apiResource('consultorios', ConsultorioController::class)->only(['index', 'show']);
    });

    // Consulta restringida: Desarrollador no puede ver pacientes ni citas
    Route::middleware('role:Administrador,Supervisor')->group(function () {
        Route::apiResource('pacientes', PacienteController::class)->only(['index', 'show']);
        Route::apiResource('citas-medicas', CitaMedicaController::class)->only(['index', 'show']);
    });

    // Escritura solo Administrador
    Route::middleware('role:Administrador')->group(function () {
        Route::apiResource('pacientes', PacienteController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('medicos', MedicoController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('especialidades', EspecialidadController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('consultorios', ConsultorioController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('citas-medicas', CitaMedicaController::class)->only(['store', 'update', 'destroy']);
    });
});
