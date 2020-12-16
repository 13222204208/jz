<?php

namespace App\Http\Controllers\Api\Goods;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsListController extends Controller
{
    public function list(Request $request)
    {
        if($request->has('id')){
            $data= Good::where('id',$request->id)->get([
                'id','title','description','cover','photo','number','price','content'
            ])->first();
            if($data){
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
            } else {
                return response()->json([ 'code' => 0 ,'msg'=>'无数据']);
            }  
        }

        $size = 10;
        if($request->get('size')){
            $size = $request->get('size');
        }

        $page = 0;
        if($request->get('page')){
            $page = ($request->get('page') -1)*$size;
        }

        $data= Good::where('status',1)->skip($page)->take($size)->get([
            'id','title','description','cover','photo','number','price','content'
        ]);

        if($data){
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } else {
            return response()->json([ 'code' => 0]);
        }  
    }
}