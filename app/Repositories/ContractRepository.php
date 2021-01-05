<?php

namespace App\Repositories;

use App\Models\Contract;
use Illuminate\Support\Facades\DB;
use Yish\Generators\Foundation\Repository\Repository;

class ContractRepository
{
    protected $contract;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function all($limit)
    {
        return $this->contract->with(['contractPackage' =>function($query){
            $query->with('goodsPackage');
        }])->withCount(['contractPackage as contractPackage_sum' =>function($query){
            $query->select(DB::raw("sum(goods_package_qty) as goods_package_sum"));
        }])->orderBy('created_at','desc')->paginate($limit);
    }

    public function searchContract($contract_name,$limit)
    {
       return $this->contract->where('title','like','%'.$contract_name.'%')->with(['contractPackage' =>function($query){
        $query->with('goodsPackage');
        }])->withCount(['contractPackage as contractPackage_sum' =>function($query){
            $query->select(DB::raw("sum(goods_package_qty) as goods_package_sum"));
        }])->orderBy('created_at','desc')->paginate($limit);
    }
}
