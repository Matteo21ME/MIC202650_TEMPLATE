<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (raíz)
|--------------------------------------------------------------------------
|
| Las rutas de cada módulo están definidas en sus propios archivos:
|   - Modules/MicroAuth/routes/api.php   → /api/v1/auth/*, /api/v1/usuarios/*, /api/v1/roles
|   - Modules/MicroBusiness/routes/api.php → /api/v1/business/*
|
| Aquí solo se registran rutas transversales (health check, etc.).
|
*/

Route::get('/health', fn () => response()->json(['status' => 'ok', 'timestamp' => now()->toIso8601String()]));

