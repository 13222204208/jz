<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Userinfo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class ProtController extends Controller
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

    public function prot(Request $request)
    {

        try {
            if($request->has('type')){ 
                $type = intval($request->type);
                if($this->user->role_id != $request->type){
                    if($type == 1){
                        $roleName= '业主';
                    }else if($type == 2){
                        $roleName= '商家';
                    }else if($type == 3){
                        $roleName= '工程师';
                    }else{
                        $roleName= '其中的角色'; 
                    }
                    
                    $msg = '你不是'.$roleName;
                    return response()->json([ 'code' => 0 , 'msg' =>$msg]);
                } 
                return response()->json([ 'code' => 1 , 'msg' =>'成功']);
            }
            return response()->json([ 'code' => 0 , 'msg' =>'参数错误']);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }
}
