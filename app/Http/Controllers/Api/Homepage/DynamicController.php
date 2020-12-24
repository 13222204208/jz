<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Models\Userinfo;
use App\Models\UserDynamic;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class DynamicController extends Controller
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
    
    public function dynamic()
    {
        try {
            $id = $this->user->id;
            $myData = UserDynamic::where('user_id',$id)->where('status',2)->get()->toArray();//得出当前业主美图
            $data= UserDynamic::where('user_id','!=',$id)->where('status',2)->get()->toArray();//得出其它业主美图
            $newData= array_merge($myData,$data);
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $newData]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function like(Request $request)
    {
        try {
            $user = Userinfo::find($this->user->id);
            $dynamic = UserDynamic::find($request->id);
            if($user->hasVoted($dynamic)){
                return response()->json([ 'code' => 0 ,'msg'=>'你已经点过赞了']);
            }
            
            $state= $user->upVote($dynamic);

            if(count(array_filter($state))){
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
