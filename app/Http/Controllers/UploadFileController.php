<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public $filename;
    
    public $imgpath;
    public function uploadFile($filename, $imgpath)
    {
        $file = $filename;
        $url_path = $imgpath;
   
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
      
            $newName =  date('YmdHis').mt_rand(100,999). "." . $entension;
            $file->move($url_path, $newName);
            $namePath = $url_path . '/' . $newName;
            return $namePath; 
         
        } else {
            return false;
        }

    }

    public function file(Request  $request)
    {
        $namePath= $this->uploadFile($request->file('file'),'contractFiles');
        
        if ($namePath) {
            $data['src'] = $namePath;
            return response()->json([ 'code' => 0 ,'msg'=>'','data' =>$data]);
        } else {
            return response()->json([ 'code' => 403]);
        }   
    }
}
