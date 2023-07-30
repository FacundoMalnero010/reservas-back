<?php

namespace modules\Consultas\routes;

use modules\Consultas\Http\Controllers\V1\ConsultasController;
use Illuminate\Support\Facades\Route;

Route::prefix('consultas')->group(function(){
    Route::get('/',        [ConsultasController::class, 'index'])   ->name('consultas.index');
    Route::get('/{id}',    [ConsultasController::class, 'get'])     ->name('consultas.get');
    Route::post('/',       [ConsultasController::class, 'store'])   ->name('consultas.store');
    Route::put('/{id}',    [ConsultasController::class, 'update'])  ->name('consultas.update');
    Route::delete('/{id}', [ConsultasController::class, 'destroy']) ->name('consultas.destroy');
});