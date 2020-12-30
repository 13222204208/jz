<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Cart;
use App\Models\Good;
use App\Models\Collect;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class CollectController extends Controller
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
    
    public function collect(Request $request)//收藏产品
    {
           try {
            if(!$request->has('id')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少商品id']);
            }
            $id = $request->id;//商品id
            $cart = Cart::where('userinfo_id',$this->user->id)->first();
            if(!$cart){
                $cart = new Cart();
                $cart->userinfo_id = $this->user->id;
                $cart->save();
            }
  
            $state= CartItem::where('cart_id',$cart->id)->where('product_id',$id)->increment('quantity');
            if(!$state){
                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->cart_id = $cart->id;
                $cartItem->save(); 
            }
            return response()->json([ 'code' => 1 ,'msg'=>'收藏成功']);

        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }  

/*           try {
            if(!$request->has('id')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少商品id']);
            }
            $id = $request->id;//商品id
            $state= Collect::where('id',$this->user->id)->where('goods_id',$id)->where('status',1)->first();
            if($state == null){
                Collect::create([
                    'goods_id' => $id,
                    'userinfo_id' => $this->user->id
                ]);
                return response()->json([ 'code' => 1 ,'msg'=>'收藏成功']);
            }
            return response()->json([ 'code' => 0 ,'msg'=>'你已收藏过这个产品']);

        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }   */
    }

    public function collectList(Request $request)//产品收藏列表
    {

         try {
            $size = 10;
            if($request->get('size')){
                $size = $request->get('size');
            }
    
            $page = 0;
            if($request->get('page')){
                $page = ($request->get('page') -1)*$size;
            }
            $cart = Cart::where('userinfo_id',$this->user->id)->first();
            if(!$cart){
                $cart = new Cart();
                $cart->userinfo_id = $this->user->id;
                $cart->save();
            }
            $items = $cart->cartItems->skip($page)->take($size);

            $arr = array();
            foreach ($items as $item) {
              $quantity= $item->quantity;
              $product=  $item->product->first()->toArray();
              $product['quantity'] = $quantity;
              $arr[] = $product;
            }

            $gnum= $cart->cartItems->count();
            $arrs['count'] = $gnum;//产品种类
            $arrs['goods'] = $arr;
            return response()->json([ 'code' => 1 ,'msg'=>'成功','data'=> $arrs]);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        } 

    }

    public function defined(Request $request)//保存方案 删除收藏产品
    {
        try {
            if(!$request->has('id')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少商品id']);
            }

            $goods_id = explode(',',$request->id);

            if($request->type != ''){
                $type = $request->type;
                if($type == 'del'){
                    $cart = Cart::where('userinfo_id',$this->user->id)->first();
                    if(!$cart){
                        return response()->json([ 'code' => 0 ,'msg'=>'错误']);
                    }
                    CartItem::where('cart_id',$cart->id)->whereIn('product_id',$goods_id)->delete();
                    return response()->json([ 'code' => 1 ,'msg'=>'删除成功']);
                }

                if($type == 'create'){
                    $cart = Cart::where('userinfo_id',$this->user->id)->first();
                    if(!$cart){
                        return response()->json([ 'code' => 0 ,'msg'=>'错误']);
                    }
                    $goods= CartItem::where('cart_id',$cart->id)->whereIn('product_id',$goods_id)->get();
                    foreach ($goods as $good) {
                        Collect::create([
                            'goods_id' => $good->product_id,
                            'userinfo_id' => $this->user->id,
                            'quantity' => $good->quantity
                        ]);
                    }
                    return response()->json([ 'code' => 1 ,'msg'=>'成功']);
                }


            }
            return response()->json([ 'code' => 0 ,'msg'=>'参数错误']);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

    public function goodsNum(Request $request)//更改产品数量
    {
        try {
            if(!$request->has('type')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少参数']);
            }

            if(!$request->has('id')){
                return response()->json([ 'code' => 0 ,'msg'=>'缺少商品id']);
            }
            $id = $request->id;
            $type = $request->type;

            $cart = Cart::where('userinfo_id',$this->user->id)->first();
            if(!$cart){
                return response()->json([ 'code' => 0 ,'msg'=>'错误']);
            }

            if($type == 'increment'){
                $state= CartItem::where('cart_id',$cart->id)->where('product_id',$id)->increment('quantity');
                if($state){
                    return response()->json([ 'code' => 1 ,'msg'=>'成功']);
                }
            }

            if($type == 'decrement'){
                $qua= CartItem::where('cart_id',$cart->id)->where('product_id',$id)->pluck('quantity')->first();
                if($qua <= 1){
                    return response()->json([ 'code' => 0 ,'msg'=>'数量最少为一']);
                }
                $state= CartItem::where('cart_id',$cart->id)->where('product_id',$id)->decrement('quantity');
                if($state){
                    return response()->json([ 'code' => 1 ,'msg'=>'成功']);
                }
            }

            return response()->json([ 'code' => 0 ,'msg'=>'参数错误']);
        } catch (\Throwable $th) {
            $err = $th->getMessage();
            return response()->json([ 'code' => 0 ,'msg'=>$err]);
        }
    }

}
