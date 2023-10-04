<?php

namespace modules\Reservas\routes;

use modules\Consultas\Http\Controllers\V1\AdministradoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('administradores')->group(function (){
    Route::get('/',        [AdministradoresController::class, 'index'])   ->name('admin.index');
    Route::get('/{id}',    [AdministradoresController::class, 'get'])     ->name('admin.get');
    Route::post('/save',   [AdministradoresController::class, 'store'])   ->name('admin.store');
    Route::post('/login',  [AdministradoresController::class, 'login'])   ->name('admin.login');
    Route::put('/{id}',    [AdministradoresController::class, 'update'])  ->name('admin.update');
    Route::delete('/{id}', [AdministradoresController::class, 'destroy']) ->name('admin.destroy');
});

