<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Models\Userinfo;
use App\Models\UserDynamic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DynamicController extends Controller
{
    public function dynamic()
    {
        try {
            $myData = UserDynamic::where('user_id',13)->where('status',2)->get()->toArray();//得出当前业主美图
            $data= UserDynamic::where('user_id','!=',13)->where('status',2)->get()->toArray();//得出其它业主美图
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
            $user = Userinfo::find(14);
            $dynamic = UserDynamic::find($request->id);
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
