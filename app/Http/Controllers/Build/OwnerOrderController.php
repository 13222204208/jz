<?php

namespace App\Http\Controllers\Build;

use App\Models\Contract;
use App\Models\Userinfo;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use App\Models\DoneConstruction;
use App\Models\UnderConstruction;
use App\Models\BeforeConstruction;
use App\Models\FinishConstruction;
use App\Http\Controllers\Controller;
use App\Repositories\ContractRepository;

class OwnerOrderController extends Controller
{
    protected $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');

        if($request->has('order_num')){
            $data = BuildOrder::orderBy('created_at','desc')->where('order_status',2)->where('order_num',$request->order_num)->paginate($limit);
            return $data;
        }

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

    public function updateOrder(Request $request,$id)
    {
        $data = $request->all();
        $data = array_filter($data);
        $state=  BuildOrder::where('id',$id)->update($data);
        if($state){
            return response()->json([ 'status' => 200 ,'msg'=>'成功']);
        } else {
            return response()->json([ 'status' => 403]);
        }  
    }

    public function merchant(Request $request)
    {
        $limit = $request->get('limit');
        //$data= Userinfo::where('is_seller',1)->paginate($limit);
        //$data= BuildOrder::where('order_status',1)->paginate($limit);
        $data = $this->contractRepository->all($limit);
        return $data;
    }

    public function relevance(Request $request , $id)
    {
        $order_id = $request->order_id;
        $order= Contract::find($order_id);
        $state= BuildOrder::where('id',intval($id))->update([
            'merchant_id' => $order->merchant_id,
            'agreement_id' => $order->id
        ]);

        if($state){
            return response()->json([ 'status' => 200 ,'msg'=>'成功']);
        } else {
            return response()->json([ 'status' => 403]);
        }  
    }
}
