<?php

namespace App\Http\Controllers\Build;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Models\BuildBetweenGoods;
use App\Http\Controllers\Controller;

class OrderGoodsController extends Controller
{
    public function goods(Request $request)
    {
        $goods_id = BuildBetweenGoods::where('build_order_id',$request->id)->pluck('goods_id');
        $goodsInfo = Good::whereIn('id',$goods_id)->get();
        return response()->json([ 'status' => 200 ,'msg'=>'成功','data'=> $goodsInfo]);
    }
}
