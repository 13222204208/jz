<?php

namespace App\Repositories;

use App\Models\GoodsPackage;
use Yish\Generators\Foundation\Repository\Repository;

class GoodsPackageRepository
{
    protected $model;

    public function __construct(GoodsPackage $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }
}
