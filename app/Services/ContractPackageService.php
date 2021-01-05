<?php

namespace App\Services;

use App\Repositories\ContractPackageRepository;
use Yish\Generators\Foundation\Service\Service;

class ContractPackageService
{
    protected $repository;

    public function __construct(ContractPackageRepository $repository)
    {
        $this->repository = $repository;
    }

  
}
