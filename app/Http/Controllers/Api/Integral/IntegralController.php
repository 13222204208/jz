<?php

namespace App\Http\Controllers\Api\Integral;

use App\Models\BuildOrder;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class IntegralController extends Controller
{
    
    public function integralExchanges(Request $request)
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
            $integralSum= BuildOrder::where('merchant_id',$user->id)->where('status',4)->sum('integral');
            if($data['integral'] > $integralSum){
                return $this->failed('你最多只能兑换'.$integralSum.'积分');
            }
            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }
}
