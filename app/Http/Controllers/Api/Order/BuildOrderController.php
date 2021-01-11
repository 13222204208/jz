<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Good;
use App\Models\Contract;
use App\Models\Userinfo;
use App\Models\BuildOrder;
use App\Models\GoodsPackage;
use Illuminate\Http\Request;
use App\Models\ContractPackage;
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
            $qty= ContractPackage::where('contract_id',$data['agreement_id'])->where('goods_package_id',$data['goods_id'])->pluck('goods_package_qty')->first();
           
            if($qty < 1){
                return response()->json([ 'code' => 0 ,'msg'=>'剩余套数不够','qty'=>$data]);
            }
      
            unset($data['token']);
            $data['merchant_id'] = $this->user->id;
            $data['order_num'] = 'GC'.time().rand(1000,9999);
            unset($data['goods_id']);
            $id = BuildOrder::create($data)->id;

            ContractPackage::where('contract_id',$data['agreement_id'])->where('goods_package_id',$request->goods_id)->decrement('goods_package_qty');//当添加一个工程单，合同分配的套餐数量减一
            Contract::where('id',$data['agreement_id'])->increment('done_quantity');

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
            if($request->agreement_id != ''){//根据合同ID获取商家剩余的套餐
                $data= ContractPackage::where('contract_id',$request->agreement_id)->where('goods_package_qty','!=',0)->get();
               
                $arr = array();
                foreach ($data as $value) {
                    $goodsPackage = GoodsPackage::where('id',$value->goods_package_id)->first();
                    
                    $value->id= $goodsPackage->id;
                    $value->goods_package_name = $goodsPackage->title;
                    $arr[] = $value;
                } 
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]);
            }

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
