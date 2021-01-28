<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProtocolController extends Controller
{
    public function createProtocol(Request $request)
    {
        $state= DB::table('protocols')->insert([
            'title' => $request->title,
            'content' => $request->content,
            'key' => $request->key
        ]);

        if ($state) {
            return response()->json(['status'=>200]);
        }else{
             return response()->json(['status'=>403]);
        }
    }

    public function gainProtocol(Request $request)//查看用户协议
    { 
       
        if ($request->ajax()) {
            $limit = $request->get('limit');
            $data= DB::table('protocols')->paginate($limit);

            return $data;
      
        }
    }


    public function editProtocol(Request $request)//修改用户协议
    {
        if ($request->ajax()) { 
            $state= DB::table('protocols')->where('id',intval($request->id))->update([
                 'content' => $request->content
            ]);
            if ($state) {
                return response()->json(['status'=>200]);
            }else{
                 return response()->json(['status'=>403]);
            }
        }
    }
}
