<?php

declare(strict_types=1);

namespace modules\Consultas\Dto\V1;

use App\Dto\BaseDto;

/**
 * @OA\Schema(
 *     @OA\Property(property="id",          description="id de la consulta",                     type="unsignedBigInteger", example=1),
 *     @OA\Property(property="nombre",      description="nombre del consultante",                type="string",             example=Facundo),
 *     @OA\Property(property="apellido",    description="apellido del consultante",              type="string",             example=Malnero),
 *     @OA\Property(property="email",       description="email del consultante",                 type="tinyInteger",        example=abc@gmail.com),
 *     @OA\Property(property="consulta",    description="consulta",                              type="string",             example="¿A qué hora cierra?"),
 *     @OA\Property(property="created_at",  description="fecha de creación de la consulta",      type="timestamps",         example="2023-12-05 12:35:27"),
 *     @OA\Property(property="updated_at",  description="fecha de actualización de la consulta", type="timestamps",         example="2023-12-05 12:35:29"),
 * )
 */

class ConsultaDto extends BaseDto
{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $consulta;
    protected $created_at;
    protected $updated_at;
}

?>
