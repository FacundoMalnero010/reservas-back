<?php

namespace app\Repository;

use Illuminate\Database\Eloquent\Model;

class EloquentRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }
}
