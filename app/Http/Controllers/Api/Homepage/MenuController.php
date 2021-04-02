<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Models\GoodsPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Protocol;

class MenuController extends Controller
{
    public function menu(Request $request)
    {
        try {
            $data= GoodsPackage::where('status',1)->where("deleted_state",1)->get();
            if($request->type == 'zn'){
                if($data){
                    return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data[0]->content]);
                } else {
                    return response()->json([ 'code' => 0]);
                }  
            }

            if($request->type == 'qs'){
                if($data){
                    return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data[1]->content]);
                } else {
                    return response()->json([ 'code' => 0]);
                }  
            }

            if($request->type == 'qw'){
                if($data){
                    return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data[2]->content]);
                } else {
                    return response()->json([ 'code' => 0]);
                }  
            }

            if($request->type == 'protocol'){
                $data = Protocol::first();
                if($data){
                    return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data->content]);
                } else {
                    return response()->json([ 'code' => 0]);
                }  
            }
  
    
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }
}