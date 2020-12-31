<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Good;
use App\Models\Contract;
use App\Models\Userinfo;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\BuildBetweenGoods;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\PackageBetweenGoods;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BuildOrderController extends Controller
{
    protected $user;

    public function __construct()
    {

        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            
            return response()->json([ 'code' => 0 , 'msg' =>$th->getMessage()]);
        }
    }
    
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
                    'goods_id' => 'required',//产品Id
                    'order_name' => 'required'//项目名称
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确',
                    'max' => ':attribute最长:max字符'
                ],
                [
                    'owner_name' => '业主名称',
                    'owner_phone' => '业主手机号',
                    'owner_address' => '业主地址',
                    'functionary' => '负责人名称',
                    'functionary_phone' => '负责人联系方式',
                    'time' => '时间',
                    'agreement_id' => '合同',
                    'goods_id' => '套内详单',
                    'order_name' => '项目名称'
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }

 
            unset($data['token']);
            $data['merchant_id'] = $this->user->id;
            $data['order_num'] = 'GC'.time().rand(1000,9999);
            unset($data['goods_id']);
            $id = BuildOrder::create($data)->id;


            $gid= PackageBetweenGoods::where('goods_package_id',$request->goods_id)->pluck('goods_id');

            foreach ($gid as  $goods_id) {//插入工程订单和商品关联的表
                    BuildBetweenGoods::create([
                    'build_order_id' => $id,
                    'goods_id' => intval($goods_id)
                ]);
            }
            DB::commit();
            return response()->json([ 'code' => 1 ,'msg'=>'成功']);

        } catch (\Throwable $th) {
            DB::rollback();//数据库回滚

            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }

    public function list(Request $request)//工程订单列表及详情
    {

        try {
            if($request->id != ''){//查询订单详情
                $data= BuildOrder::find(intval($request->id));
                $goods_id = BuildBetweenGoods::where('build_order_id',intval($request->id))->pluck('goods_id');
                $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品
    
                $data['goods_id'] = $ginfo;
      
                
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
    
            $data= BuildOrder::skip($page)->take($size)->where('merchant_id',$this->user->id)->where('status',$status)->get(); 
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function contract(Request $request)
    {
        try {
            $status = 1; 

            if($request->status != ''){
                $status = $request->status;
            }

            $size = 10;
            if($request->size){
                $size = $request->size;
            }
    
            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            }
            
            $data= Contract::where('merchant_id',$this->user->id)->where('status',$status)->skip($page)->take($size)->get();
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function doneContract(Request $request)
    {
        try {

            $size = 10;
            if($request->size){
                $size = $request->size;
            }
    
            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            }

            $data= Contract::where('merchant_id',$this->user->id)->skip($page)->take($size)->get();
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

}
