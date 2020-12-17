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

    public function truename(Request $request)//安装工程师实名认证
    {
        $data = $request->all();
        $validator = Validator::make(//验证数据字段
            $data,
            [
                'truename' => 'required|max:20',
                'id_number' => 'required',
                'phone' => 'required|regex:/^1[345789][0-9]{9}$/',
                'id_front' => 'required',
                'id_the_back' => 'required',
                'id_in_hand' => 'required',
            ]        
        );

        
        if ($validator->fails()) {
            return response()->json([ 'code' => 0 ,'msg'=>$validator->errors()]);
        }

        $result =  \Ofcold\IdentityCard\IdentityCard::make($request->id_number);//验证身份证号

        if ( $result === false ) {
            return response()->json([ 'code' => 0 ,'msg'=>'你的身份证号码不正确']);
        }

        $state = Userinfo::where('id',1)->update($data);//编辑用户资料，暂时为1

        if ($state) {
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } else {
            return response()->json([ 'code' => 0 , 'msg' => '失败']);
        }   
    }

}