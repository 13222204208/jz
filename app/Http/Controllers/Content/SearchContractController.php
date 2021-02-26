<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Repositories\ContractRepository;

class SearchContractController extends Controller
{
    protected $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function searchContract(Request $request)
    {
        $limit= $request->get('limit');
    
        $data = $request->all();
        
        return $this->contractRepository->searchContract($data,$limit);
    }

    public function updateContract(Request $request , $id)
    {
        $data = $request->all();
        $data = array_filter($data);
        $state = Contract::where('id',$id)->update($data);
        if($state){
            return response()->json([ 'status' => 200 ,'msg'=>'成功']);
        } else {
            return response()->json([ 'status' => 403]);
        }  
    }
}
