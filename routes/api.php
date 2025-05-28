<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PilotoController;


Route::get('/pilotos', [PilotoController::class, 'index']);

Route::apiResource('pilotos', PilotoController::class);

/*Route::middleware('api')->group(function () {
    Route::get('/pilotos', [PilotoController::class, 'index']);
});*/

//06-05-2025//

Route::apiResource('z_pilotos', PilotoController::class);

