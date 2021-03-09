<?php

namespace App\Http\Controllers\User;

use App\Models\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BuildOrder;

class SellerListController extends Controller
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
            $data= Userinfo::where('is_seller',1)->orderBy('created_at','desc')->paginate($limit);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if($request->ajax()){
            $limit = $request->get('limit');
            $data= Userinfo::where('phone','like','%'.$id.'%')->orderBy('created_at','desc')->paginate($limit);
            return $data;
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
        //
    }

    public function sellerOrder(Request $request, $id)
    {
        if($request->ajax()){
            $limit = $request->get('limit');
            $data= BuildOrder::where('merchant_id',$id)->where('status',4)->paginate($limit);
            return $data;
         }
    }
}
