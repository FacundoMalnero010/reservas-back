<?php

namespace modules\Reservas\routes;

use modules\Consultas\Http\Controllers\V1\AdministradoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('administradores')->controller(AdministradoresController::class)->group(function (){

    Route::get ('/login',   'formLogin') ->name('admin.loginForm');
    Route::post('/logout',  'logout')    ->name('admin.logout');
    Route::get ('/home',    'home')      ->name('admin.home')    ->middleware('auth:sanctum');

    Route::fallback(function (){
        return redirect()->route('homeAdmin');
    });

});
