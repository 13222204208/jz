<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public $filename;
    
    public $imgpath;
    public function uploadImg($filename, $imgpath)
    {
        $file = $filename;
        $url_path = $imgpath;
        $rule = ['jpg', 'png', 'gif', 'jpeg'];
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            if (!in_array($entension, $rule)) {
                return '图片格式为jpg,png,gif,jpeg';
            }
            $newName =  date('YmdHis').mt_rand(100,999). "." . $entension;
            $file->move($url_path, $newName);
            $namePath = $url_path . '/' . $newName;
            return $namePath; 
         
        } else {
            return false;
        }

    }

    public function uploadImgs(Request  $request)
    {
        $namePath= $this->uploadImg($request->file('file'),'goodsImg');
        
        if ($namePath) {
            $data['src'] = $namePath;
            return response()->json([ 'code' => 0 ,'msg'=>'','data' =>$data]);
        } else {
            return response()->json([ 'code' => 403]);
        }   
    }

    public function contentImg(Request  $request)
    {
        $namePath= $this->uploadImg($request->file('file'),'goods');
        $d = pathinfo($namePath); return $d;
        if ($namePath) {
            $data['src'] = $d['basename'];
            return response()->json([ 'code' => 0 ,'msg'=>'','data' =>$data]);
        } else {
            return response()->json([ 'code' => 403]);
        }   
    }

    public function caseInfoImg(Request  $request)
    {
        $namePath= $this->uploadImg($request->file('file'),'content');
        $d = pathinfo($namePath); 
        if ($namePath) {
            $data['src'] = $d['basename'];
            return response()->json([ 'code' => 0 ,'msg'=>'','data' =>$data]);
        } else {
            return response()->json([ 'code' => 403]);
        }   
    }
}
