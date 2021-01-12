<?php

namespace App\Http\Controllers\User;

use App\Models\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserInfoController extends Controller
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
            $data= Userinfo::paginate($limit);
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
        $state= Userinfo::where('id',$id)->update([
            'status' => request('status')
        ]);

        
        if ($state) {
            return response()->json([ 'status' => 200]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
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
        $role=  $request->role;

        $arr = array();
        if(in_array('is_owner',$role)){
            $arr['is_owner'] = 1;
        }else{
            $arr['is_owner'] = 0;
        }
      
        if(in_array('is_seller',$role)){
            $arr['is_seller'] = 1;
        }else{
            $arr['is_seller'] = 0;
        }

        if(in_array('is_engineer',$role)){
            $arr['is_engineer'] = 1;
        }else{
            $arr['is_engineer'] = 0;
        }
      
        $state= Userinfo::where('id',$id)->update($arr);

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
        //
    }
}
