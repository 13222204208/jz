<?php

namespace App\Http\Controllers\Goods;

use App\Models\GoodsPackage;
use Illuminate\Http\Request;
use App\Models\PackageBetweenGoods;
use App\Http\Controllers\Controller;
use Facade\Ignition\Support\Packagist\Package;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
           $limit = $request->get('limit');
           $data= GoodsPackage::paginate($limit);
           return $data;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//保存套餐及套餐和产品中间表
    {
        if($request->ajax()){
            $goodsPackage = new GoodsPackage;
            $goodsPackage->title = $request->title;
            $goodsPackage->cover = $request->cover;
            $goodsPackage->package_price = $request->package_price;
            $goodsPackage->content = $request->content;
            if($goodsPackage->save()){ 
                $goodsId= array_filter(explode(',',$request->goods_id));
                
                foreach($goodsId as $gid ){
                    $state = PackageBetweenGoods::create([
                        'goods_id' => $gid,
                        'goods_package_id' => $goodsPackage->id
                    ]);
                }

                
            if ($state) {
                return response()->json([ 'status' => 200]);

            } else {

                return response()->json([ 'status' => 403]);
            }   
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    { 
   
        $gp = GoodsPackage::find($id)->children()->get();
                        
        if ($gp) {
            return response()->json([ 'status' => 200,'data'=> $gp]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $state= GoodsPackage::where('id',$id)->update([
            'status' => $request->status
        ]);

        if ($state) {
            return response()->json([ 'status' => 200]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state= GoodsPackage::destroy($id);

        if ($state) {
            return response()->json([ 'status' => 200]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
    }

    public function updateGroup(Request $request,$id)
    {
        $data = json_decode(json_encode($request->except('file')), true);
      
        $state= GoodsPackage::where('id',$id)->update($data);

        if ($state) {
            return response()->json([ 'status' => 200]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
    }
}
