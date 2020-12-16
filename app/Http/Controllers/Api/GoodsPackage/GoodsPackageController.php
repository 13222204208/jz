<?php

namespace App\Http\Controllers\Api\GoodsPackage;


use App\Models\GoodsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsPackageController extends Controller
{
    public function list()//获取套餐列表详情
    {
        $data= GoodsPackage::where('status',1)->select('title','id')->with('children:id,title,price,cover,description')->get();

        if($data){
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } else {
            return response()->json([ 'code' => 0]);
        }  
    }
}
