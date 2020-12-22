<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Good;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\DoneConstruction;
use App\Models\BuildBetweenGoods;
use App\Models\UnderConstruction;
use App\Models\BeforeConstruction;
use App\Http\Controllers\Controller;

class ConstructController extends Controller
{
    public function rate(Request $request)//业主显示的施工进度
    {
        try {
            if($request ->id != ''){
                $id = $request->get('id');        
                $data= BuildOrder::find(intval($id),['status','engineer_id','created_at','order_num']);
                $goods_id = BuildBetweenGoods::where('build_order_id',intval($request->id))->pluck('goods_id');
                $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品

                $data['goods_id'] = $ginfo;
        
                $before = BeforeConstruction::where('order_num',$data['order_num'])->get(['photo','comments','created_at'])->first();
                $under = UnderConstruction::where('order_num',$data['order_num'])->get(['photo','comments','created_at']);
        
                $data['before'] = $before;
                $data['under'] = $under;

                return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
            }

            $data = BuildOrder::where('owner_phone','15568992117')->get(['id','engineer_id','order_name','status','created_at']);
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }
}
