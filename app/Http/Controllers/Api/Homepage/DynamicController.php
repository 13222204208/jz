<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Models\Comment;
use App\Models\Userinfo;
use App\Models\UserDynamic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    
    public function dynamic(Request $request)
    {
        $size = 20;
        if($request->size){
            $size = $request->size;
        }

        $page = 0;
        if($request->page){
            $page = ($request->page -1)*$size;
        }

        try {
     
            if(!$this->id){
                $myData= UserDynamic::where('status',2)->skip($page)->take($size)->orderBy('created_at','desc')->get()->toArray();//得出其它业主美图
            }else{
                $id = $this->user->id;
                $myData = UserDynamic::where('status',2)->orderByRaw(DB::raw('FIELD(user_id, '.$id.') desc'))->skip($page)->take($size)->get();//得出当前业主美图
            }
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $myData]);
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
                $user->cancelVote($dynamic);
                return response()->json([ 'code' => 1 ,'msg'=>'已取消点赞']);
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

                $size = 20;
                if($request->size){
                    $size = $request->size;
                }
        
                $page = 0;
                if($request->page){
                    $page = ($request->page -1)*$size;
                }

                if($request->comment_id != ''){
                    $comment_id = $request->comment_id;
                    $data= Comment::where('parent_id',$comment_id)->skip($page)->take($size)->orderBy('created_at','desc')->get();
                    $listCount = Comment::where('parent_id',$comment_id)->count();
                    $arr['list_count'] = $listCount;
                    $arr['list_comments'] = $data;
                    return response()->json([ 'code' => 1 ,'msg'=>'成功','data' => $arr]);
                }

                $dynamic_id = $request->dynamic_id;
                $dynamic = UserDynamic::find($dynamic_id);


                $arr= Comment::where('user_dynamic_id',$dynamic_id)->where('parent_id',null)->orderBy('created_at','desc')->skip($page)->take($size)->get();
                
                $mData = array();

                foreach ($arr as $value) {
                    $count= Comment::where('parent_id',$value->id)->count();
                    $value->count = $count;
                    $mData[] = $value;
                }
    
                $datas = array();
                $datas['dynamic']['title'] = $dynamic->title;
                $datas['dynamic']['owner_cover'] = $dynamic->owner_cover;
                $datas['dynamic']['owner_nickname'] = $dynamic->owner_nickname;  
                $datas['dynamic']['photo'] = $dynamic->photo;  
                $datas['dynamic']['like_count'] = $dynamic->like_count;  
                $datas['dynamic']['created_at'] = $dynamic->created_at;  
                $datas['dynamic']['like_status'] = $dynamic->like_status;  
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
