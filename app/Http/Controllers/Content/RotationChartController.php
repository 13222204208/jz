<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use App\Models\RotationChart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;

class RotationChartController extends Controller
{
    public function uploadRotationImg(Request $request)
    {
        $upload= new UploadController;
        $namePath= $upload->uploadImg($request->file('file'),'RotationImg');
        if ($namePath) {
            return response()->json(['path' =>$namePath, 'status' => 200]);
        } else {
            return response()->json(['path' =>$namePath, 'status' => 403]);
        }    
    }

    public function createChart(Request $request)
    {
        if ($request->ajax()) {
            try {
                $request->validate([
                    'img_url' => 'required|max:200',
                    'img_sort' => 'required|max:12',
                ]); 
            } catch (\Throwable $th) {
                return response()->json(['status'=>403]);
            }

            if ($request->state == "on") {
                $state =1;
            }else{
                $state = 0;
            }

            $rotation= new RotationChart;
            $rotation->img_url = $request->img_url;
            $rotation->img_sort = $request->img_sort;
            $rotation->title = $request->title;
            $rotation->jump_url = $request->jump_url;
            $rotation->state = $state;
            $id = $rotation->save();

            if ($id) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 403]);
            }  
        }
    }

    public function queryRotationList(Request $request)
    {
        $limit= $request->get('limit');
        $data= DB::table('bg_rotation_chart')->paginate($limit);
        return $data;
    }

    public function delRotationChart(Request $request)
    {
        if ($request->ajax()) {
            $chart = RotationChart::find($request->id);
            $state= $chart->delete();

            if ($state) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 403]);
            }  
        }
    }

    public function updateRotationChart(Request $request)
    {
        if ($request->ajax()) {
            if ($request->state =="on") {
                $state = 1;
            }else{
                $state = 0;
            }
            $chart = RotationChart::find($request->id);
            $chart->img_sort = intval($request->img_sort);
            $chart->state = $state;
            $chart->title = $request->title;
            $chart->jump_url = $request->jump_url;
            $state = $chart->save();
            
            if ($state) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 403]);
            }  
        }
    }
}
