<?php

namespace App\Http\Controllers\User;

use App\Models\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchUserController extends Controller
{
    public function search(Request $request)
    {
        $name = $request->name;
        $role_id = $request->role_id;

        $limit = $request->get('limit');
        $data= Userinfo::when($name,function($query) use ($name){
           return  $query->where('nickname',$name)->orWhere('truename',$name);
        })->when($role_id,function($query) use ($role_id){
            return  $query->where('role_id',intval($role_id));
         })->paginate($limit);
        return $data;
    }
}
