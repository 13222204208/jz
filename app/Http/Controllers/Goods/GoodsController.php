<?php

namespace App\Http\Controllers\Goods;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsType;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit= $request->get('limit');
        $data= Good::paginate($limit);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//保存产品
    {
        if($request->ajax()){ 
            
            $good = new Good;
            $good ->title =$request->title;
            $good->description = $request->description;
            $good->photo = $request->photo;
            $good->number = $request->number;
            $good->price = $request->price;
            $good->package_price = $request->package_price;//套餐单价
            $good->content = $request->content;
            $good->cover = $request->cover;
            $state= $good->save(); 

            if ($state) {
                 return response()->json([ 'status' => 200]);
 
             } else {
 
                 return response()->json([ 'status' => 403]);
             }   
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data= GoodsType::all();

        if ($data) {
            return response()->json([ 'status' => 200,'data'=>$data]);

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
        $data = json_decode(json_encode($request->except('file')), true);
        
        $state= Good::where('id',$id)->update($data);

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
        $state= Good::destroy($id);

        if ($state) {
            return response()->json([ 'status' => 200]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
    }
}
