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
                $user= Userinfo::find($this->user->id);
                return response()->json([ 'code' => 1 , 'msg' =>'成功','data'=> $user]);
            return response()->json([ 'code' => 0 , 'msg' =>'参数错误']);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }
}
