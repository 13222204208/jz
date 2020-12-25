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
    protected $id;

    public function __construct()
    {

        try {
            $this->user = JWTAuth::parseToken()->authenticate();
            $this->id = true;
        } catch (\Throwable $th) {
            $this->id = false; 
            return response()->json([ 'code' => 0 , 'msg' =>$th->getMessage()]);
        }
    }
    
    public function dynamic()
    {
        try {
     
            if(!$this->id){
                $newData= UserDynamic::where('status',2)->get()->toArray();//得出其它业主美图
            }else{
                $id = $this->user->id;
                $myData = UserDynamic::where('user_id',$id)->where('status',2)->get()->toArray();//得出当前业主美图
                $data= UserDynamic::where('user_id','!=',$id)->where('status',2)->get()->toArray();//得出其它业主美图
                $newData= array_merge($myData,$data);
            }
     

            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $newData]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function like(Request $request)//美图点赞
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

    public function dynamicDetail(Request $request)//获取美图的详情
    {
        try {
            if($request->dynamic_id != ''){

                $dynamic_id = $request->dynamic_id;
                $dynamic = UserDynamic::find($dynamic_id);
                $dynamic->load('comments.owner');
                $comments = $dynamic->getComments();
                $comments['comments'] = $comments[''];
                unset($comments['']);
            
             
                $arr = $comments['comments'];
           
                foreach ($comments as $key => $value) {
                    foreach ($comments['comments'] as $k => $comment) {
                        if($key == $comment->id){
                            $arr[$k]['list'] = $value;
                        }
                    }
                }
                           
    
                $datas = array();
                $datas['dynamic']['title'] = $dynamic->title;
                $datas['dynamic']['owner_cover'] = $dynamic->owner_cover;
                $datas['dynamic']['owner_nickname'] = $dynamic->owner_nickname;  
                $datas['comments'] = $arr;
        
                return response()->json([ 'code' => 1 ,'msg'=>'成功','data' => $datas]);
            }
            return response()->json([ 'code' => 0 ,'msg'=>'错误']);
            
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }

    }
}
