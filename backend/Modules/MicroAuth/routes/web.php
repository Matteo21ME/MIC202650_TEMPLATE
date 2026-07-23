<?php

use Illuminate\Support\Facades\Route;
use Modules\MicroAuth\Http\Controllers\MicroAuthController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('microauths', MicroAuthController::class)->names('microauth');
});
