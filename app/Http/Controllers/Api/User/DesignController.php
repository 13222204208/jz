<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Design;
use App\Models\GoodsType;
use App\Models\HouseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DesignController extends Controller
{
    public function formType()//表单类型
    {
        try {
           $houseType_name= HouseType::get(['name','id']);
           $type_name = GoodsType::get(['name','id']);

           $data['house_type_name'] = $houseType_name;
           $data['type_name'] = $type_name;
           return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function design(Request $request)//提交智能设计数据
    {
        try {
            $data = $request->all();
            
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'house_type' => 'required',
                    'goods_type' => 'required',
                    'phone' => 'required|regex:/^1[345789][0-9]{9}$/'
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确',
                ],
                [
                    'house_type' => '户型',
                    'goods_type' =>'类型',
                    'phone' => '手机号'
                ]   
            );

            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }

            $state = Design::create($data);
            if($state){
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);
            }else{
                return response()->json([ 'code' => 0 ,'msg'=>'失败']);
            }
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }
}
