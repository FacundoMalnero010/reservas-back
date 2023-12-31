<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('administradores', function(Blueprint $tabla){
            $tabla->id();
            $tabla->string('nombre');
            $tabla->string('apellido');
            $tabla->string('usuario');
            $tabla->string('password');
            $tabla->timestamps();
            $tabla->string('estado');
            $tabla->rememberToken();
            $tabla->string('logueado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
