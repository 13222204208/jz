<?php

namespace App\Repositories;

use App\Models\ContractPackage;
use Yish\Generators\Foundation\Repository\Repository;

class ContractPackageRepository
{
    protected $model;

    public function __construct(ContractPackage $model)
    {
        $this->model = $model;
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }
}
