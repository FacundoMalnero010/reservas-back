<?php

namespace App\Models\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AdministradorApp extends Model
{
    public $table = 'administradores';

    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'usuario',
        'created_at',
        'updated_at',
        'estado',
    ];
}
