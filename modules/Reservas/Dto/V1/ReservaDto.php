<?php

declare(strict_types=1);

namespace modules\Reservas\Dto\V1;

use App\Dto\BaseDto;

/**
 * @OA\Schema(
 *     @OA\Property(property="id",         description="id de la reserva",        type="unsignedBigInteger", example=1),
 *     @OA\Property(property="fecha",      description="fecha de la reserva",     type="date",               example=2023-05-17),
 *     @OA\Property(property="horario",    description="horario de la reserva",   type="time",               example=15:30:00),
 *     @OA\Property(property="comensales", description="cantidad de comensales",  type="tinyInteger",        example=4),
 *     @OA\Property(property="email",      description="email de quien reserva",  type="string",             example="abc@gmail.com"),
 *     @OA\Property(property="nombre",     description="nombre de quien reserva", type="string",             example="Facundo"),
 * )
 */

class ReservaDto extends BaseDto
{
    protected $id;
    protected $fecha;
    protected $horario;
    protected $comensales;
    protected $email;
    protected $nombre;
}

?>
