<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Good;
use App\Models\Collect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectController extends Controller
{
    public function collect(Request $request)//收藏产品
    {
        try {
            if(!$request->has('id')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少商品id']);
            }
            $id = $request->id;
            $state= Collect::where('id',1)->where('goods_id',$id)->where('status',1)->first();
            if($state == null){
                Collect::create([
                    'goods_id' => $id,
                    'userinfo_id' => 1
                ]);
                return response()->json([ 'code' => 1 ,'msg'=>'收藏成功']);
            }
            return response()->json([ 'code' => 0 ,'msg'=>'你已收藏过这个产品']);

        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function collectList()//产品收藏列表
    {
        try {
            $goods_id= Collect::where('userinfo_id',1)->where('status',1)->pluck('goods_id');
            $data = Good::whereIn('id',$goods_id)->get(['id','title','description','price','cover']);
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function defined(Request $request)//保存方案
    {
        try {
            if(!$request->has('id')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少商品id']);
            }

            $goods_id = explode(',',$request->id);

            Collect::where('userinfo_id',1)->where('status',2)->delete();
            foreach ($goods_id as $gid) {
                Collect::create([
                    'goods_id' => $gid,
                    'userinfo_id' => 1,
                    'status' =>2
                ]);
            }
            return response()->json([ 'code' => 1 ,'msg'=>'成功']);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }
}
