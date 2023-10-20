<?php

namespace modules\Reservas\routes;

use Illuminate\Support\Facades\Route;
use modules\Consultas\Http\Controllers\V1\ConsultasController;

Route::controller(ConsultasController::class)->group(function (){

    Route::get ('/',   'index') ->name('index');

    Route::fallback(function (){
        return redirect()->route('index');
    });

});
