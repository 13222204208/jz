<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        
        return $this->contractRepository->searchContract($data['contract_name'],$limit);
    }
}
