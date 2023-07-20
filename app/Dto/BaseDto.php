<?php

declare(strict_types=1);

namespace App\Dto;

use JsonSerializable;

abstract class BaseDto implements JsonSerializable
{
    //El constructor se encarga de completar el array asociativo
    //con los valores correspondientes
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    //Esta función crea el array asociativo con los datos que recibe
    protected function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    //Esta función obtiene los atributos del objeto y los separa
    //para usarlos como claves
    public function toArray()
    {
        return get_object_vars($this);
    }
}

?>
