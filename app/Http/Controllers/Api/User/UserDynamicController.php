<?php

namespace App\Http\Controllers\Api\User;

use App\Models\UserDynamic;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserDynamicController extends Controller
{
    protected $user;

    public function __construct()
    {

        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
            
            return response()->json([ 'code' => 0 , 'msg' =>$th->getMessage()]);
        }
    }

    public function dynamic(Request $request)//业主美图发布
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'photo' => 'required',
                    'title' => 'required'
                ],
                [
                    'required' => ':attribute不能为空'
                ],
                [
                    'photo' => '图片',
                    'title' => 'title'
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }
            
            $data['user_id'] = $this->user->id;
            unset($data['token']);
            $state = UserDynamic::create($data);
    
            if ($state) {
                return response()->json([ 'code' => 1 ,'msg'=>'成功']);
            } else {
                return response()->json([ 'code' => 0 , 'msg' => '失败']);
            }  
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        } 

    }

    public function myDynamic(Request $request)
    {
        try {
            $size = 20;
            if($request->size){
                $size = $request->size;
            }
    
            $page = 0;
            if($request->page){
                $page = ($request->page -1)*$size;
            }

            $data= UserDynamic::where('user_id',$this->user->id)->skip($page)->take($size)->get(['title','photo','created_at','user_id','id']);
            if ($data) {
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' =>$data]);
            } else {
                return response()->json([ 'code' => 0 , 'msg' => '失败']);
            } 
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }

    public function comment(Request $request)//评论美图 
    {
        try {
            $data = $request->all();
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'dynamic_id' => 'required',
                    'content' => 'required'
                ],
                [
                    'required' => ':attribute不能为空'
                ],
                [
                    'dynamic_id' => '美图ID',
                    'content' => '评论内容'
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'code' => 0 ,'msg'=>$messages]);
            }

            $dynamic = UserDynamic::find($request->dynamic_id);
            $id = $dynamic->comments()->create([
                'content' => request('content'),
                'userinfo_id' => $this->user->id,
                'parent_id' => request('parent_id',null)
            ])->id;
            
            if($id){
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
