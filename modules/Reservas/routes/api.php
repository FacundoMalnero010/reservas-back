<?php

namespace modules\Reservas\routes;

use modules\Reservas\Http\Controllers\V1\ReservasController;
use Illuminate\Support\Facades\Route;

Route::prefix('reservas')->group(function(){
    Route::get('/',       [ReservasController::class, 'index'])  ->name('reservas.index');
    Route::get('/{id}',   [ReservasController::class, 'get'])    ->name('reservas.get');
    Route::post('/',      [ReservasController::class, 'store'])  ->name('reservas.store');
    Route::put('/{id}',   [ReservasController::class, 'update']) ->name('reservas.update');
    Route::delete('{id}', [ReservasController::class, 'destroy'])->name('reservas.destroy');
});