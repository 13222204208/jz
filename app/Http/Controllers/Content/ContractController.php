<?php

namespace App\Http\Controllers\Content;

use App\Models\Contract;
use App\Models\Userinfo;
use App\Models\BuildOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\ContractRepository;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
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
    {//DB::select('alter table contracts add partner varchar(60)  null ');
        $limit = $request->get('limit');
        $data = $this->contractRepository->all($limit);
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
            $validator = Validator::make(//验证数据字段
                $data,
                [
                    'title' => 'required|max:150|unique:contracts',//业主名字
                ],
                [
                    'required' => ':attribute不能为空',
                    'unique' => ':attribute不能重复',
                    'max' => ':attribute最长:max字符',
                ],
                [
                    'title' => '合同名称',
                ]        
            );
    
            if ($validator->fails()) {
                $messages = $validator->errors()->first();
                return response()->json([ 'status' => 403 ,'msg'=>$messages]);
            }

        unset($data['file']);
        $state= Contract::create($data);

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
    public function show(Request $request,$id)
    {
        $limit = $request->get('limit');
        $data= Userinfo::where('is_seller',1)->paginate($limit);
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
        $state= Contract::where('id',intval($id))->update([
            'merchant_id' => $request->merchant_id,
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
        $status = BuildOrder::where('agreement_id',$id)->first();
        if($status){
            return response()->json([ 'status' => 403]);
        }
        
        $state = $this->contractRepository->delContract($id);
        if($state){
            return response()->json([ 'status' => 200 ,'msg'=>'成功']);
        } else {
            return response()->json([ 'status' => 403]);
        }  
    }
}
