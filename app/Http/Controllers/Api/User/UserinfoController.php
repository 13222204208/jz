<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Userinfo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UploadController;

class UserinfoController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request(['username', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data['token'] = $token;
        return response()->json([
            'code' => 1,
            'msg' =>"成功",
            'data' => $data
        ],200);
    }

    public function uploadImg(Request $request)
    {
        $upload = new UploadController;

        $img_url= $upload->uploadImg($request->img, 'imgs');

        if ($img_url) {
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$img_url]);
        } else {
            return response()->json([ 'code' => 0 , 'msg' => '上传失败']);
        }   
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(//验证数据字段
            $data,
            [
                'phone' => 'required|regex:/^1[345789][0-9]{9}$/',
            ]        
        );

        if ($validator->fails()) {
            return response()->json([ 'code' => 0 ,'msg'=>$validator->errors()]);
        }
    
        $state = Userinfo::where('id',1)->update($data);//编辑用户资料，暂时为1

        if ($state) {
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } else {
            return response()->json([ 'code' => 0 , 'msg' => '上传失败']);
        }   

    }

}