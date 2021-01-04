<?php

namespace App\Http\Controllers\Build;

use App\Models\Userinfo;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\DoneConstruction;
use App\Models\UnderConstruction;
use App\Models\BeforeConstruction;
use App\Models\FinishConstruction;
use App\Http\Controllers\Controller;

class OwnerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $data = BuildOrder::orderBy('created_at','desc')->where('order_status',2)->paginate($limit);
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
        $order_num = $request->order_num;
        $before = BeforeConstruction::where('order_num',$order_num)->get(['photo','comments','created_at'])->first();
        $under = UnderConstruction::where('order_num',$order_num)->get(['photo','comments','created_at']);
        $finish = FinishConstruction::where('order_num',$order_num)->get(['photo','comments','created_at'])->first();
        $done = DoneConstruction::where('order_num',$order_num)->get(['owner_sign_photo','engineer_sign_photo','created_at'])->first();

        $data['before'] = $before;
        $data['under'] = $under;
        $data['finish'] = $finish;
        $data['done'] = $done;
 
        return response()->json([ 'status' => 200 ,'msg'=>'成功','data'=> $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $limit = $request->get('limit');
        $data= Userinfo::where('is_engineer',1)->paginate($limit);
        return $data;
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
        $state= BuildOrder::where('id',intval($id))->update([
            'engineer_id' => $request->engineer_id
        ]);

        if($state){
            return response()->json([ 'status' => 200 ,'msg'=>'成功']);
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
        $state = BuildOrder::destroy($id);
        
        if($state){
            return response()->json([ 'status' => 200 ,'msg'=>'成功']);
        } else {
            return response()->json([ 'status' => 403]);
        }  
    }
}
