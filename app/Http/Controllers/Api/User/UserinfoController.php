<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

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

}
