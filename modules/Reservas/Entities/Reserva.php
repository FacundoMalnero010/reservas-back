<?php

namespace modules\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    public $table = 'reservas';

    public $fillable = [
        'id',
        'fecha',
        'horario',
        'comensales',
        'email',
        'nombre',
    ];
}
