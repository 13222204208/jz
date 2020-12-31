<?php

namespace App\Http\Controllers\Api\Engineer;

use App\Models\Good;
use App\Models\News;
use App\Models\AfterSale;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\DoneConstruction;
use App\Models\BuildBetweenGoods;
use App\Models\UnderConstruction;
use App\Models\BeforeConstruction;
use App\Models\FinishConstruction;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EngineerController extends Controller
{
    protected $msg =[
        'required' => ':attribute不能为空',
        'unique' => ':attribute不唯一',
        'max' => ':attribute最长:max字符'
    ];

    protected $custom =[
        'order_num' => '订单号',
        'photo' => '图片',
        'owner_sign_photo' => '业主签字图片',
        'engineer_sign_photo' => '工程师签字图片'
    ];

    protected $user;

    public function __construct()
    {

        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            
            return response()->json([ 'code' => 0 , 'msg' =>$th->getMessage()]);
        }
    }

    public function list(Request $request)//工程订单列表及详情
    {

        try {         
            if($request->long != '' && $request->lat != ''){
                $long = $request->long;
                $lat = $request->lat;

                if($request->id != ''){//查询订单详情
                    $data= BuildOrder::find(intval($request->id),['id','status','engineer_id','owner_name','owner_phone','owner_address','created_at','order_num','order_name','owner_demand','long','lat']);
                    $data['distance'] = $this->distance($long,$data->long,$lat,$data->lat);

                    $done= DoneConstruction::where('order_num',$data->order_num)->first();
                    $owner_sign_photo = '';
                    $engineer_sign_photo = '';
                    if($done){
                        $owner_sign_photo = $done->owner_sign_photo;
                        $engineer_sign_photo = $done->engineer_sign_photo;
                    }
                    $data['owner_sign_photo'] = $owner_sign_photo;
                    $data['engineer_sign_photo'] = $engineer_sign_photo;
                    
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
    
                $status = 1;
                if($request->status != ''){
                    $status = intval($request->get('status'));
                    $data= BuildOrder::skip($page)->take($size)->where('engineer_id',$this->user->id)->where('status',$status)->get();
                    $arr = array();
                    foreach($data as $d){ 
                        $done= DoneConstruction::where('order_num',$d->order_num)->first();
                        $owner_sign_photo = '';
                        $engineer_sign_photo = '';
                        if($done){
                            $owner_sign_photo = $done->owner_sign_photo;
                            $engineer_sign_photo = $done->engineer_sign_photo;
                        }
                        $d->owner_sign_photo = $owner_sign_photo;
                        $d->engineer_sign_photo = $engineer_sign_photo;
    
                        $d->distance= $this->distance($long,$d->long,$lat,$d->lat);
                        $arr[]= $d;
                    }
                    return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]);
                }
        
                $data= BuildOrder::skip($page)->take($size)->where('engineer_id',$this->user->id)->orderByRaw(DB::raw('FIELD(status, 1) desc'))->get();
             
                $arr = array();
                foreach($data as $d){ 
                    $done= DoneConstruction::where('order_num',$d->order_num)->first();
                    $owner_sign_photo = '';
                    $engineer_sign_photo = '';
                    if($done){
                        $owner_sign_photo = $done->owner_sign_photo;
                        $engineer_sign_photo = $done->engineer_sign_photo;
                    }
                    $d->owner_sign_photo = $owner_sign_photo;
                    $d->engineer_sign_photo = $engineer_sign_photo;

                    $d->distance= $this->distance($long,$d->long,$lat,$d->lat);
                    $arr[]= $d;
                }
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]); 
            }
        
            if($request->id != ''){//查询订单详情
                $data= BuildOrder::find(intval($request->id),['id','status','engineer_id','owner_name','owner_phone','owner_address','created_at','order_num','order_name','owner_demand','long','lat']);
                
                $done= DoneConstruction::where('order_num',$data->order_num)->first();

                $owner_sign_photo = '';
                $engineer_sign_photo = '';
                if($done){
                    $owner_sign_photo = $done->owner_sign_photo;
                    $engineer_sign_photo = $done->engineer_sign_photo;
                }
                $data['owner_sign_photo'] = $owner_sign_photo;
                $data['engineer_sign_photo'] = $engineer_sign_photo;
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

            $status = 1;
            if($request->status != ''){
                $status = intval($request->get('status'));
                $data= BuildOrder::skip($page)->take($size)->where('engineer_id',$this->user->id)->where('status',$status)->get();

                $arr = array();
                foreach($data as $d){ 
                    $done= DoneConstruction::where('order_num',$d->order_num)->first();
                    $owner_sign_photo = '';
                    $engineer_sign_photo = '';
                    if($done){
                        $owner_sign_photo = $done->owner_sign_photo;
                        $engineer_sign_photo = $done->engineer_sign_photo;
                    }
                    $d->owner_sign_photo = $owner_sign_photo;
                    $d->engineer_sign_photo = $engineer_sign_photo;
    
                    $arr[]= $d;
                }
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]);
            }
    
            $data= BuildOrder::skip($page)->take($size)->where('engineer_id',$this->user->id)->orderByRaw(DB::raw('FIELD(status, 1) desc'))->get();

            $arr = array();
            foreach($data as $d){ 
                $done= DoneConstruction::where('order_num',$d->order_num)->first();
                $owner_sign_photo = '';
                $engineer_sign_photo = '';
                if($done){
                    $owner_sign_photo = $done->owner_sign_photo;
                    $engineer_sign_photo = $done->engineer_sign_photo;
                }
                $d->owner_sign_photo = $owner_sign_photo;
                $d->engineer_sign_photo = $engineer_sign_photo;

                $arr[]= $d;
            }

            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=>$arr]); 
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function schedule(Request $request)
    {
        try {
            $data = $request->all();

            if($data['type'] == 'before'){//施工前
                unset($data['type']);
                unset($data['token']);
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
                BuildOrder::where('order_num',$data['order_num'])->update([
                    'status' =>2
                ]);
                BeforeConstruction::create($data);
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);

            }


            if($data['type'] == 'under'){//施工中
                unset($data['type']);
                unset($data['token']);
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

            if($data['type'] == 'finish'){//施工完成
                unset($data['type']);
                unset($data['token']);
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

                FinishConstruction::create($data);
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

    public function done(Request $request)//竣工
    {
        try {
                $data = $request->all();
          
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
                unset($data['token']);
                DoneConstruction::create($data);
                $state = BuildOrder::where('order_num',$data['order_num'])->update([
                    'status' =>3
                ]);

                if($state){
                    $order = BuildOrder::where('order_num',$data['order_num'])->first();
                    News::create([
                        'order_id'=> $order->id,
                        'order_num' => $order->order_num,
                        'userinfo_phone' =>$order->owner_phone,
                        'comments' => '订单已完成',
                        'order_status' =>3,
                    ]);
                    return response()->json([ 'code' => 1 ,'msg'=>'成功']);
                }else{
                    return response()->json([ 'code' => 0 ,'msg'=>'参数类型错误']);
                }

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
            $finish = FinishConstruction::where('order_num',$order_num)->get(['photo','comments','created_at'])->first();

            $id = BuildOrder::where('order_num',$order_num)->pluck('id')->first();

            $data['before'] = $before;
            $data['under'] = $under;
            $data['finish'] = $finish;
            $data['order_num'] = $order_num;
            $data['id'] = $id;
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $data]);

        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function after(Request $request)
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
            $data = AfterSale::where('engineer_id',$this->user->id)->where('status','!=',4)->skip($page)->take($size)->get(['order_num','goods_name','hitch_content','user_id','engineer_id','created_at','status']);
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function afterStatus(Request $request)
    {
        try {
            if($request->order_num != ''){
                $order_num = $request->order_num;
            }

            if($request->type != ''){
                $type = $request->type;
                if($type == 'done'){
                    AfterSale::where('order_num',$order_num)->update([
                        'status' => 3
                    ]);
                    return response()->json([ 'code' => 1 ,'msg'=>'成功']);
                }

                if($type == 'del'){
                    AfterSale::where('order_num',$order_num)->update([
                        'status' => 4
                    ]);
                    return response()->json([ 'code' => 1 ,'msg'=>'成功']);
                }

            }
            return response()->json([ 'code' => 0 ,'msg'=>'参数错误']);
           
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    
    public function distance($lat1,$lat2,$lng1,$lng2)
    {
        $radLat1 = deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137;
        return round($s,3)*1000;//返回米数
    }

}
