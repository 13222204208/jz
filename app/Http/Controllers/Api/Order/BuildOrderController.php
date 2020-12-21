<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Good;
use App\Models\Userinfo;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\BuildBetweenGoods;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BuildOrderController extends Controller
{
    public function create(Request $request)//添加工程订单
    {
        DB::beginTransaction();//开启事务

        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'owner_name' => 'required|max:50',//业主名字
                    'owner_phone' => 'required|regex:/^1[345789][0-9]{9}$/',//业主联系方式 
                    'owner_address' => 'required|max:150',//业主地址
                    'functionary' => 'required|max:50',//负责人
                    'functionary_phone' => 'required|regex:/^1[345789][0-9]{9}$/',//负责人联系方式
                    'time' => 'required|max:50',//时间
                    'agreement_id' => 'required',//合同id
                    //'merchant_id' => 'required',//商家id由后端获取
                    'goods_id' => 'required',//产品Id
                ]        
            );
    
            if ($validator->fails()) {
                return response()->json([ 'code' => 0 ,'msg'=>$validator->errors()]);
            }
   
            $data['order_num'] = time().rand(10000,99999);
            unset($data['goods_id']);
            $id = BuildOrder::create($data)->id;

            $goods_ids = explode(',',$request->goods_id);//获取商品id 

            foreach ($goods_ids as  $goods_id) {//插入工程订单和商品关联的表
                    BuildBetweenGoods::create([
                    'build_order_id' => $id,
                    'goods_id' => intval($goods_id)
                ]);
            }
            DB::commit();
            return response()->json([ 'code' => 1 ,'msg'=>'成功']);

        } catch (\Throwable $th) {
            DB::rollback();//数据库回滚

            return response()->json([ 'code' => 0 , 'msg' => $th]);
        }

    }

    public function list(Request $request)//工程订单列表及详情
    {

        try {
            if($request->id != ''){//查询订单详情
                $data= BuildOrder::find(intval($request->id),['status','owner_name','owner_phone','owner_address','functionary',
                        'functionary_phone','time','agreement_id','owner_demand','engineer_id']);
                $goods_id = BuildBetweenGoods::where('build_order_id',intval($request->id))->pluck('goods_id');
                $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品
    
                $data['goods_id'] = $ginfo;
                $data['engineer_name']="";
                $data['engineer_phone']=""; 
                if($data['engineer_id'] != null){
                    $einfo = explode(',',$data['engineer_id']);
                    $data['engineer_name']=$einfo[0];
                    $data['engineer_phone']=$einfo[1];
                } 
                
               return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
            }
    //根据工程状态展示列表
            $status = 1;
            if($request->status != ''){
                $status = intval($request->status);
            }
    
            $size = 10;
            if($request->size){
                $size = $request->size;
            }
    
            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            }
    
            $data= BuildOrder::skip($page)->take($size)->where('status',$status)->get(['id','status','owner_name','owner_phone','owner_address','functionary','functionary_phone','time','agreement_id','owner_demand','engineer_id']);
            $arr = array();
            foreach($data as $d){ 
                $goods_id = BuildBetweenGoods::where('build_order_id',$d['id'])->pluck('goods_id');
            
                $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品
        
                $d['goods_id'] = $ginfo;
                $d['engineer_name']="";
                $d['engineer_phone']=""; 
                if($d['engineer_id'] != null){
                    $einfo = explode(',',$d['engineer_id']);
                    $d['engineer_name']=$einfo[0];
                    $d['engineer_phone']=$einfo[1];
                } 
                $arr[]= $d;
            }
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]);
        } catch (\Throwable $th) {
            return response()->json([ 'code' => 0 ,'msg'=>$th]);
        }
    }

}