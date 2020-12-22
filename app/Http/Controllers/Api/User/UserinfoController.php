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
        try {
            $upload = new UploadController;
            if($request->img == ''){
                return response()->json([ 'code' => 0 , 'msg' => '文件不能为空']);
            }

            $img_url= $upload->uploadImg($request->img, 'imgs');
    
            if ($img_url) {
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$img_url]);
            } else {
                return response()->json([ 'code' => 0 , 'msg' => '上传失败']);
            }   
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }

    public function edit(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'phone' => 'required|regex:/^1[345789][0-9]{9}$/',
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确'
                ],
                [
                    'phone' => '手机号'
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }
        
            $state = Userinfo::where('id',1)->update($data);//编辑用户资料，暂时为1
    
            if ($state) {
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
            } else {
                return response()->json([ 'code' => 0 , 'msg' => '失败']);
            }   
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }

    public function truename(Request $request)//安装工程师实名认证
    {
        try {
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
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确',
                    'max' => ':attribute最多20位'
                ],
                [
                    'truename' => '真实姓名',
                    'id_number' => '身份证号',
                    'phone' => '手机号',
                    'id_front' => '身份证正面',
                    'id_the_back' => '身份证反面',
                    'id_in_hand' => '手持身份证',
                ]        
            );
    
            
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
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
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }

}