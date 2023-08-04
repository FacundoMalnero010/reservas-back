<?php

namespace App\Models\Entities\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministradorApp extends Model
{

    use HasFactory;

    public $table = 'administradores';

    public $fillable = [
        'id',
        'nombre',
        'apellido',
        'usuario',
        'created_at',
        'updated_at',
        'estado',
    ];

    protected $hidden = ['password'];

}
