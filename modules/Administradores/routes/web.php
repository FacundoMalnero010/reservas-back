<?php

namespace modules\Reservas\routes;

use modules\Consultas\Http\Controllers\V1\AdministradoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('administradores')->group(function (){
    Route::get('/login', [AdministradoresController::class, 'formLogin'])->name('login');
    Route::post('/logout', [AdministradoresController::class, 'logout'])  ->name('admin.logout');
    Route::get('/home', [AdministradoresController::class, 'home'])->middleware('auth:sanctum')->name('homeAdmin');
});


