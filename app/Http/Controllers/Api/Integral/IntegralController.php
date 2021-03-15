<?php

namespace App\Http\Controllers\Api\Integral;

use App\Models\BuildOrder;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Integral;
use App\Models\IntegralExchange;
use App\Traits\OrderNum;
use Illuminate\Support\Facades\Validator;

class IntegralController extends Controller
{
    use OrderNum;

    protected $user;

    public function __construct()
    {

        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            
            return response()->json([ 'code' => 0 , 'msg' =>$th->getMessage()]);
        }
    }
    
    public function integralExchanges(Request $request)//积分兑换
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'integral' => 'required|integer'
                ],
                [
                    'required' => ':attribute不能为空',
                    'integer' => ':attribute为整数'
                ],
                [
                    'integral' => '积分',
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }

            $user= JWTAuth::parseToken()->authenticate();
            $integralSum= $user->integral;
            if($data['integral'] > $integralSum){
                return $this->failed('你最多还能兑换'.$integralSum.'积分');
            }
        
            $today= date('Y-m-d',time());
            $num= IntegralExchange::whereDate('created_at',$today)->count();
            
            $user->decrement('integral', $data['integral']);
            $user->save();

            $integralExchange= new IntegralExchange;
            $integralExchange->order_num= $this->createOrderNum($num, 'E');
            $integralExchange->integral= $data['integral'];
            $integralExchange->user_id= $user->id;
            $integralExchange->save();

            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function integralRecord(Request $request)
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
    
            $data= IntegralExchange::skip($page)->take($size)->where('user_id',$this->user->id)->get();
    
            return $this->success($data);  
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
