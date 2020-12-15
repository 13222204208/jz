<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Models\GoodsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function menu()
    {
        $data= GoodsPackage::where('status',1)->get(['id','title','cover']);
  
        if($data){
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } else {
            return response()->json([ 'code' => 0]);
        }  
    }
}