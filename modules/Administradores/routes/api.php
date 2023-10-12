<?php

namespace modules\Reservas\routes;

use modules\Consultas\Http\Controllers\V1\AdministradoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('administradores')->controller(AdministradoresController::class)->group(function (){
    Route::get('/',        'index')   ->name('admin.index');
    Route::get('/{id}',    'get')     ->name('admin.get');
    Route::post('/save',   'store')   ->name('admin.store');
    Route::post('/login',  'login')   ->name('admin.login');
    Route::put('/{id}',    'update')  ->name('admin.update');
    Route::delete('/{id}', 'destroy') ->name('admin.destroy');
});

