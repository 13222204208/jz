<?php

namespace App\Http\Controllers\Build;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\IntegralExchange;
use App\Http\Controllers\Controller;

class IntegralExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try { 
            $limit= $request->get('limit');
            $data= IntegralExchange::with('nickName')->orderBy('created_at','desc')->paginate($limit);
            return $data;
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        try { 
            $limit= $request->get('limit');
            $data= IntegralExchange::with('nickName')->where('order_num',$id)->orderBy('created_at','desc')->paginate($limit);
            return $data;
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
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
        try {
            $exchange= IntegralExchange::find($id);
            $exchange->voucher= $request->voucher;
            $exchange->status= 2;
            $exchange->examine= session('username');
            $exchange->examine_time= Carbon::now()->toDateTimeString();
            $exchange->save();

            return $this->success();
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
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
