<?php

namespace App\Http\Controllers\Api\CaseInfo;

use App\Http\Controllers\Controller;
use App\Models\CaseInfo;
use Illuminate\Http\Request;

class CaseInfoController extends Controller
{
    public function list(Request $request)//查询案例和资讯
    {
        if($request->has('id')){//根据Id查找
            $data= CaseInfo::find($request->get('id'),['title','cover','tag','content','photo','id']);
            if($data){
                return response()->json([
                    'code' => 1,
                    'msg' => '查询成功',
                    'data'=> $data
                ], 200);
            }else{
                return response()->json([
                    'code' => 0,
                    'msg' => '错误',
                ], 200);
            }
        }

        if($request->has('type')){//根据类型查找
            $type = $request->get('type');
        }else{
            $type ="case";//默认为案例
        }
       

        $size = 10;
        if($request->has('size')){
            $size = $request->get('size');
        }

        $page = 0;
        if($request->has('page')){
            $page = ($request->get('page') -1)*$size;
        }

        $data= CaseInfo::where('type',$type)->where('status',1)->skip($page)->take($size)->get(['title','cover','tag']);

        if($data){
            return response()->json([
                'code' => 1,
                'msg' => '查询成功',
                'data'=> $data
            ], 200);
        }else{
            return response()->json([
                'code' => 0,
                'msg' => '错误',
            ], 200);
        }
    }
}
