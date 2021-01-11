<?php

namespace App\Models;

use App\Models\Userinfo;
use App\Models\ContractPackage;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use Timestamp,HasFactory;

    protected $guarded = [];

    protected $appends = ['merchant_name','merchant_phone'];

    public function contractPackage()
    {
        return $this->hasMany('App\Models\ContractPackage');
    }

    public function getMerchantNameAttribute()
    {
        $id = $this->attributes['merchant_id']; 
        if($id != 0){
            $user= Userinfo::find($id);
            return $user->nickname;
        }
        return '无';
    }

    public function getMerchantPhoneAttribute()
    {
        $id = $this->attributes['merchant_id']; 
        if($id != 0){
            $user= Userinfo::find($id);
            return $user->phone;
        }
        return '无';
    }
}
