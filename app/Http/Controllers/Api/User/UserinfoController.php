<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
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

}