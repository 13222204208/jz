<?php

namespace App\Http\Controllers\Goods;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            $good->content = $request->content;
            $good->cover = $request->content;
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
        //
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
        //
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
