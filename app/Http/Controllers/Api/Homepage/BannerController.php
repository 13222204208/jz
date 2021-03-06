<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Http\Controllers\Controller;
use App\Models\RotationChart;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner()//首页banner图
    {
        try {
            $data = RotationChart::where('state',1)->get(['title','img_url','jump_url','img_sort']);

            if($data){
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
            } else {
                return response()->json([ 'code' => 0]);
            }  
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }
}