<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserDynamic;
use Illuminate\Support\Facades\Validator;

class UserDynamicController extends Controller
{
    public function dynamic(Request $request)//业主美图发布
    {
        $data = $request->all();
        $validator = Validator::make(//验证数据字段
            $data,
            [
                'photo' => 'required',
            ]        
        );

        if ($validator->fails()) {
            return response()->json([ 'code' => 0 ,'msg'=>$validator->errors()]);
        }
        
        $data['user_id'] = 12;
        $state = UserDynamic::create($data);

        if ($state) {
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } else {
            return response()->json([ 'code' => 0 , 'msg' => '上传失败']);
        }   

    }
}
