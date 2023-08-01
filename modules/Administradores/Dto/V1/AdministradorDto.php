<?php

declare(strict_types=1);

namespace modules\Administradores\Dto\V1;

use App\Dto\BaseDto;

/**
 * @OA\Schema(
 *     @OA\Property(property="id",          description="id del administrador",                     type="unsignedBigInteger", example=1),
 *     @OA\Property(property="nombre",      description="nombre del administrador",                 type="string",             example=Facundo),
 *     @OA\Property(property="apellido",    description="apellido del administrador",               type="string",             example=Malnero),
 *     @OA\Property(property="usuario",     description="usuario del administrador",                type="string",             example=facu08),
 *     @OA\Property(property="password",    description="password del usuario",                     type="string",             example="micontra"),
 *     @OA\Property(property="created_at",  description="fecha de creación del administrador",      type="timestamps",         example="2023-12-05 12:35:27"),
 *     @OA\Property(property="updated_at",  description="fecha de actualización del administrador", type="timestamps",         example="2023-12-05 12:35:29"),
 * )
 */

class AdministradoresDto extends BaseDto
{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $usuario;
    protected $password;
    protected $created_at;
    protected $updated_at;
}

?>
