<?php

use Http\Controller\V1\ReservasController;
use Illuminate\Support\Facades\Route;

Route::group('reservas/api', function () {
    Route::group('v1', function () {
        Route::get('/', [ReservasController::class, 'index'])->name('reservas.index');
    });
});

?>
