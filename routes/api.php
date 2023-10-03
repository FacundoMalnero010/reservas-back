<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Rutas para las reservas
require __DIR__.'../../modules/Reservas/routes/api.php';
//Rutas para las consultas
require __DIR__.'../../modules/Consultas/routes/api.php';
//Rutas para los admin
require __DIR__.'../../modules/Administradores/routes/api.php';

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
