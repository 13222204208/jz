<?php

namespace App\Http\Controllers\Api\User;

use EasyWeChat\Factory;
use App\Models\Userinfo;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UploadController;
use App\Models\News;

class UserinfoController extends Controller
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
    
    public function login(Request $request)
    {
        try {
            $validator = Validator::make(//验证数据字段
                $request->all(),
                [
                    'code' => 'required',
                    'nickname' => 'required',
                    'cover' => 'required'
                ],
                [
                    'required' => ':attribute不能为空',
                ],
                [
                    'code' => '微信code',
                    'nickname' =>'昵称',
                    'cover' => '头像'
                ]        
            );
            
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }

            $code = $request->code;
            // 根据 code 获取微信 openid 和 session_key
            $miniProgram = \EasyWeChat::miniProgram();
            $data = $miniProgram->auth->session($code);
            
            if (isset($data['errcode'])) {
                return response()->json([ 'code' => 0 , 'msg' => 'code 已过期或不正确']);
            }
    
            $state = Userinfo::where('wx_id',$data['openid'])->first();
            if(!$state){
                $user= Userinfo::create([
                    'nickname' => $request->nickname,
                    'cover' => $request->cover,
                    'wx_id' => $data['openid'],
                    'wx_session_key' => $data['session_key']
                ]);
                $token = JWTAuth::fromUser($user);
                $userData['nickname'] = $request->nickname;
                $userData['token'] = $token;
                $userData['cover'] = $request->cover;
                $userData['sex'] = $user->sex;
                $userData['phone'] = $user->phone;
                $userData['address'] = $user->address;
                $userData['company'] = $user->company;
                $userData['is_owner'] = $user->is_owner;
                $userData['is_seller'] = $user->is_seller;
                $userData['is_engineer'] = $user->is_engineer;

             return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$userData]);
            }
            $token = JWTAuth::fromUser($state);
            $userinfo['token'] = $token;
            $userinfo['nickname'] = $state->nickname;
            $userinfo['cover'] = $state->cover;
            $userinfo['sex'] = $state->sex;
            $userinfo['phone'] = $state->phone;
            $userinfo['address'] = $state->address;
            $userinfo['company'] = $state->company;
            $userinfo['is_owner'] = $state->is_owner;
            $userinfo['is_seller'] = $state->is_seller;
            $userinfo['is_engineer'] = $state->is_engineer;
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$userinfo]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

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
                    'token' => 'required'
                ],
                [
                    'required' => ':attribute不能为空',
                    'regex' => ':attribute格式不正确'
                ],
                [
                    'phone' => '手机号'
                ]        
            );
            unset($data['token']);
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }
        
            $state = Userinfo::where('id',$this->user->id)->update($data);//编辑用户资料，暂时为1
    
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
                    'token' =>'required'
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
            unset($data['token']);
            
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }
    
            $result =  \Ofcold\IdentityCard\IdentityCard::make($request->id_number);//验证身份证号
    
            if ( $result === false ) {
                return response()->json([ 'code' => 0 ,'msg'=>'你的身份证号码不正确']);
            }
            $data['engineer_status'] = 2;//工程师实名认证审核状态
            $state = Userinfo::where('id',$this->user->id)->update($data);//编辑用户资料，
    
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

    public function news()
    {
        try {
            $data= News::where('userinfo_phone',$this->user->phone)->get();
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

}