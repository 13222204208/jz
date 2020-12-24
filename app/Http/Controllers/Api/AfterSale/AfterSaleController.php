<?php

namespace App\Http\Controllers\Api\AfterSale;

use App\Models\AfterSale;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AfterSaleController extends Controller
{
    protected $user;

    public function __construct()
    {

        try {
            //$this->middleware('auth.jwt', ['except' => ['login']]);
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            
            return response()->json([ 'code' => 0 , 'msg' =>$th->getMessage()]);
        }
    }
    
    public function create(Request $request)//提交报修和售后表
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'goods_name' => 'required|max:100',
                    'hitch_content' => 'required|max:200',
                ],
                [
                    'required' => ':attribute不能为空',
                    'max' => ':attribute最长:max字符'
                ],
                [
                    'goods_name' => '产品名称',
                    'hitch_content' => '故障描述'
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }
            unset($data['token']);
            $data['user_id'] = $this->user->id;//默认为用户1，后续更改
            $data['order_num'] = 'GZ'.time().rand(1000,9999);
            $state= AfterSale::create($data);
    
            if($state){
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);
            } else {
                return response()->json([ 'code' => 0]);
            }  
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
     
    }
}
