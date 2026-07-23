<?php

use Illuminate\Support\Facades\Route;
use Modules\MicroBusiness\Http\Controllers\MicroBusinessController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('microbusinesses', MicroBusinessController::class)->names('microbusiness');
});
