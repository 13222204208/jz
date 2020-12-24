<?php

namespace App\Http\Controllers\Api\GoodsPackage;


use App\Models\Good;
use App\Models\Collect;
use App\Models\GoodsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsPackageController extends Controller
{
    public function list()//获取套餐列表详情
    {
        try {
            $data= GoodsPackage::where('status',1)->select('title','id')->with('children:id,title,price,cover,description')->get();
            
            if($data){
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
            } else {
                return response()->json([ 'code' => 0]);
            }  

            $goods_id = Collect::where('userinfo_id',1)->where('status',2)->pluck('goods_id');
            $data= Good::whereIn('id',$goods_id)->get();
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }
}
