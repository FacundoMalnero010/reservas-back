<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use modules\Administradores\Entities\Administrador;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administradores')->insert([
            'nombre'         => 'Facundo',
            'apellido'       => 'Malnero',
            'usuario'        => 'facukin',
            'password'       => Hash::make('password'),
            'created_at'     => now()->subHours(3),
            'updated_at'     => now()->subHours(3),
            'estado'         => 'A',
            'remember_token' => 'soyUnTokenDePrueba',
            'logueado'       => 0
        ]);
    }
}
