<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

// Autenticacion (publica)
Route::post('/auth/login', [AuthController::class, 'login']);

// Rutas protegidas: requieren token valido
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::middleware('role:Administrador, Desarrollador, Supervisor')->group(function () {
        Route::get('roles', [RoleController::class, 'index']);
        Route::get('usuarios', [UserController::class, 'index']);
    });

});
