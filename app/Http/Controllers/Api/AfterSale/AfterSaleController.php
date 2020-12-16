<?php

namespace App\Http\Controllers\Api\AfterSale;

use App\Models\AfterSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AfterSaleController extends Controller
{
    public function create(Request $request)//提交报修和售后表
    {
        $data = $request->all();
        $validator = Validator::make(//验证数据字段
            $data,
            [
                'goods_name' => 'required|max:100',
                'hitch_content' => 'required|max:200',
            ]        
        );

        if ($validator->fails()) {
            return response()->json([ 'code' => 0 ,'msg'=>$validator->errors()]);
        }
        
        $data['user_id'] = 1;//默认为用户1，后续更改
        $state= AfterSale::create($data);

        if($state){
            return response()->json([ 'code' => 1 ,'msg'=>'成功']);
        } else {
            return response()->json([ 'code' => 0]);
        }  
     
    }
}
