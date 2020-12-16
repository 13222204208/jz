<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\CaseInfo;
use App\Models\CaseTag;
use Illuminate\Http\Request;

class CaseInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $data= CaseInfo::paginate($limit);
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
        $data= $request->all();
        unset($data['file']);
        if($request->has('tag')){
            $data['tag'] = implode(',',$data['tag']);
        }

        $state= CaseInfo::create($data);
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
        $data= CaseTag::select('name','id')->get();
        if ($data) {
            return response()->json(['status' => 200,'data'=>$data]);
        } else {
            return response()->json(['status' => 403]);
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
        $data = $request->all();
        unset($data['file']);
        if($request->status == 'on'){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        $state = CaseInfo::where('id',$id)->update($data);
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
        $state = CaseInfo::destroy($id);

        if ($state) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 403]);
        }  
    }
}
