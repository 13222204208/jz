<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractPackage;
use App\Repositories\GoodsPackageRepository;

class ContractPackageController extends Controller
{
    protected $goodsPackageRepository;

    public function __construct(GoodsPackageRepository $goodsPackageRepository)
    {
        $this->goodsPackageRepository = $goodsPackageRepository;
    }

    public function getGoodsPackage()
    {
        $data= $this->goodsPackageRepository->all();

        return response()->json(['status' => 200,'data'=>$data]);
    }

    public function createContractPackage(Request $request)
    {
        $data = $request->all();
        $status= ContractPackage::where('contract_id',$data['contract_id'])->where('goods_package_id',$data['goods_package_id'])->first();
        if($status){
            if($data['type'] =='add'){
                $status->goods_package_qty += $data['goods_package_qty'];
            }else if($data['type'] == 'del'){
                $status->goods_package_qty = intval($status->goods_package_qty-$data['goods_package_qty']);
            }
            
            $status->save();
            $contract = Contract::find($data['contract_id']);
            if($data['type'] =='add'){
                $contract->quantity += intval($data['goods_package_qty']);
            }else if($data['type'] == 'del'){
                $contract->quantity -= intval($data['goods_package_qty']);
            }
           
            $contract->save();
            
            return response()->json(['status' => 200]);
        }
        unset($data['type']);
        $state= ContractPackage::create($data);

        $contract = Contract::find($data['contract_id']);
        $contract->quantity += intval($data['goods_package_qty']);
        $contract->save();

        if($state){
            return response()->json(['status' => 200]);
        }
    }
}
