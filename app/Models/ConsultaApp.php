<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaApp extends Model
{
    use HasFactory;

    public $table = 'consultas';

    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'email',
        'consulta',
        'created_at',
        'updated_at'
    ];
}
