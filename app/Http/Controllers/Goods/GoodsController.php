<?php

namespace App\Http\Controllers\Goods;

use App\Models\Good;
use Illuminate\Http\Request;
use App\Traits\ImgUrl;
use App\Http\Controllers\Controller;
use App\Models\GoodsType;

class GoodsController extends Controller
{
    use ImgUrl;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit= $request->get('limit');
        $data= Good::orderBy('created_at','desc')->select(["id","title","description","number","price","package_price","created_at"])->paginate($limit);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//保存产品
    {
        if($request->ajax()){ 
            
            $good = new Good;
            $good ->title =$request->title;
            $good->description = $request->description;
            $good->photo = $request->photo;
         
            if($request->number != ''){
                $good->number = $request->number;
            }
            $good->price = $request->price;
            if($request->package_price != ''){
                $good->package_price = $request->package_price;//套餐单价
            }
           
            $good->content = $request->content;
            $good->cover = $request->cover;
            $state= $good->save(); 

            if ($state) {
                 return response()->json([ 'status' => 200]);
 
             } else {
 
                 return response()->json([ 'status' => 403]);
             }   
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
        $data= GoodsType::all();

        if ($data) {
            return response()->json([ 'status' => 200,'data'=>$data]);

        } else {

            return response()->json([ 'status' => 403]);
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
        $data = json_decode(json_encode($request->except('file')), true);
        
        $data["content"] = $this->delImgUrl($data["content"]);
        $state= Good::where('id',$id)->update($data);

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
        $state= Good::destroy($id);

        if ($state) {
            return response()->json([ 'status' => 200]);

        } else {

            return response()->json([ 'status' => 403]);
        }   
    }

    public function checkID(Request $request)
    {
        //$limit= $request->get('limit');
        $data= Good::orderBy('created_at','desc')->get(["id","title","description","number","price","package_price","created_at"]);
    
        return response()->json(['code'=>0,'status' =>200,"data"=>$data]);
    }
}
