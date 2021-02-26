<?php

namespace App\Http\Controllers\Build;

use App\Http\Controllers\Controller;
use App\Models\Integral;
use Illuminate\Http\Request;

class IntegralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Integral::find(1);
        return response()->json([ 'status' => 200 ,'msg'=>'成功','data'=> $data]);
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
        $integral= Integral::find(1);
        if($integral){
            $integral->engineer_parameter  = $request->engineer_parameter;
            $integral->owner_parameter = $request->owner_parameter;
            $integral->save();
        }else{
            Integral::create([
                'engineer_parameter'=>$request->engineer_parameter,
                'owner_parameter'=>$request->owner_parameter,
            ]);
        }

        return response()->json([ 'status' => 200 ,'msg'=>'成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
