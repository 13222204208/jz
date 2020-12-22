<?php

namespace App\Http\Controllers\Form;

use App\Models\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $data = GoodsType::paginate($limit);
        return $data;
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
    public function store(Request $request)
    {
        $data = $request->all();
        $state= GoodsType::create($data);

        if ($state) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 403]);
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
        $state= GoodsType::where('id',$id)->update($request->all());

        if ($state) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 403]);
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
        $state = GoodsType::destroy($id);

        if ($state) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 403]);
        }  
    }
}
