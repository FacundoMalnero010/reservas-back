<?php

namespace App\Models\Entities\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaApp extends Model
{
    use HasFactory;

    public $table = 'reservas';
    public $timestamps = 'false';

    public $fillable = [
        'id',
        'fecha',
        'horario',
        'comensales',
        'email',
        'nombre',
        'created_at',
        'updated_at'
    ];
}
