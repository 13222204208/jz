<?php

namespace App\Http\Controllers\User;

use App\Models\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchUserController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->info;
/*         $role_id = 0;
        if($request->role_id != ''){
            $role_id = $request->role_id;
        } */
        $role_id = $request->input('role_id');
       
        $role = "";
        if($role_id == 1){
            $role = "is_owner";
        }else if($role_id == 2){
            $role = "is_seller";
        }else if($role_id == 3){
            $role = "is_engineer";
        }
        
        if($name == null){
            $name = false;
        }
        $limit = $request->get('limit');
       
        $data= Userinfo::when($name,function($query) use ($name){
           return  $query->where('nickname','like','%'.$name.'%')->orWhere('truename','like','%'.$name.'%');
        })->when($role_id,function($query) use ($role){
            return  $query->where($role,1);
         })->paginate($limit);
        return $data;
    }
}
