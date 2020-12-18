<?php

namespace App\Http\Controllers\Api\Engineer;

use App\Models\Good;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\BuildBetweenGoods;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EngineerController extends Controller
{
    public function list(Request $request)//工程订单列表及详情
    {

        try {
            if($request->id != ''){//查询订单详情
                $data= BuildOrder::find(intval($request->id),['status','owner_name','owner_phone','owner_address','created_at','order_num','owner_demand']);
                $goods_id = BuildBetweenGoods::where('build_order_id',intval($request->id))->pluck('goods_id');
                $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品
    
                $data['goods_id'] = $ginfo;
                
               return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
            }
    
            //安装端订单列表
            $size = 10;
            if($request->size){
                $size = $request->size;
            }
    
            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            }
    
            $data= BuildOrder::skip($page)->take($size)->where('engineer_id',20)->where('status',2)->get(['id','owner_name','owner_phone','owner_address','owner_demand']);
            $arr = array();
            foreach($data as $d){ 
                $goods_id = BuildBetweenGoods::where('build_order_id',$d['id'])->pluck('goods_id');
            
                $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品
        
                $d['goods_id'] = $ginfo;
                $arr[]= $d;
            }
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]);
        } catch (\Throwable $th) {
            return response()->json([ 'code' => 0 ,'msg'=>$th]);
        }
    }

    public function before(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'order_num' => 'required|unique:before_constructions|max:30',
                    'photo' => 'required'
                ]        
            );

            if ($validator->fails()) {
                return response()->json([ 'code' => 0 ,'msg'=>$validator->errors()]);
            }

            


        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
