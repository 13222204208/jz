<?php

namespace App\Http\Controllers\Api\Engineer;

use App\Models\Good;
use App\Models\AfterSale;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\DoneConstruction;
use App\Models\BuildBetweenGoods;
use App\Models\UnderConstruction;
use App\Models\BeforeConstruction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EngineerController extends Controller
{
    protected $msg =[
        'required' => ':attribute不能为空',
        'unique' => ':attribute唯一',
        'max' => ':attribute最长:max字符'
    ];

    protected $custom =[
        'order_num' => '订单号',
        'photo' => '图片',
        'owner_sign_photo' => '业主签字图片',
        'engineer_sign_photo' => '工程师签字图片'
    ];

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

            $status = 2;
            if($request->status != ''){
                $status = intval($request->get('status'));
            }
    
            $data= BuildOrder::skip($page)->take($size)->where('engineer_id',20)->where('status',$status)->get(['id','owner_name','owner_phone','owner_address','owner_demand']);
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

    public function schedule(Request $request)
    {
        try {
            $data = $request->all();

            if($data['type'] == 'before'){//施工前
                unset($data['type']);
                $role =[
                    'order_num' => 'required|unique:before_constructions|max:30',
                    'photo' => 'required'
                ];

                $validator = Validator::make(//验证数据字段
                    $data,$role,$this->msg,$this->custom      
                );
    
                if ($validator->fails()) {
                    $messages = $validator->errors()->first();
                    return response()->json([ 'code' => 0 ,'msg'=>$messages]);
                }

                BeforeConstruction::create($data);
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);

            }

            if($data['type'] == 'before'){//施工中
                unset($data['type']);
                $role =[
                    'order_num' => 'required|max:30',
                    'photo' => 'required'
                ];

                $validator = Validator::make(//验证数据字段
                    $data,$role,$this->msg,$this->custom      
                );
    
                if ($validator->fails()) {
                    $messages = $validator->errors()->first();
                    return response()->json([ 'code' => 0 ,'msg'=>$messages]);
                }

                UnderConstruction::create($data);
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);

            }

            if($data['type'] == 'under'){//施工中
                unset($data['type']);
                $role =[
                    'order_num' => 'required|max:30',
                    'photo' => 'required'
                ];

                $validator = Validator::make(//验证数据字段
                    $data,$role,$this->msg,$this->custom      
                );
    
                if ($validator->fails()) {
                    $messages = $validator->errors()->first();
                    return response()->json([ 'code' => 0 ,'msg'=>$messages]);
                }

                UnderConstruction::create($data);
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);

            }

            if($data['type'] == 'done'){//施工完成
                unset($data['type']);
                $role =[
                    'order_num' => 'required|max:30',
                    'owner_sign_photo' => 'required',
                    'engineer_sign_photo' => 'required',
                ];

                $validator = Validator::make(//验证数据字段
                    $data,$role,$this->msg,$this->custom      
                );
    
                if ($validator->fails()) {
                    $messages = $validator->errors()->first();
                    return response()->json([ 'code' => 0 ,'msg'=>$messages]);
                }

                DoneConstruction::create($data);
                BuildOrder::where('order_num',$data['order_num'])->update([
                    'status' =>3
                ]);
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);

            }

            return response()->json([ 'code' => 0 ,'msg'=>'参数类型错误']);
            


        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function show(Request $request)//订单进度表
    {
        try {
            if($request ->has('order_num')){
                $order_num = $request->get('order_num');
            }else{
                return response()->json([ 'code' => 0 ,'msg'=>'缺少订单号']);
            }

            $before = BeforeConstruction::where('order_num',$order_num)->get(['photo','comments','created_at'])->first();
            $under = UnderConstruction::where('order_num',$order_num)->get(['photo','comments','created_at']);
            $done = DoneConstruction::where('order_num',$order_num)->get(['owner_sign_photo','engineer_sign_photo','created_at'])->first();

            $data['before'] = $before;
            $data['under'] = $under;
            $data['done'] = $done;
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $data]);

        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function after()
    {
        try {
            $data = AfterSale::where('engineer_id',10)->get(['order_num','user_id','engineer_id','created_at','status']);
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }
}
