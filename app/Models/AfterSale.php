<?php

namespace App\Models;

use App\Models\Userinfo;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class AfterSale extends Model
{
    use Timestamp;

    protected $table = 'after_sale';
    
    protected $guarded = [];

    protected $appends = ['owner_name','owner_phone','status_value','engineer','owner_address'];

    public function userinfo()
    {
        $owner_id = $this->attributes['user_id'];
        $userinfo = Userinfo::find($owner_id);
        return $userinfo;
    }

    public function getOwnerNameAttribute()
    {
        return $this->userinfo()->nickname;
    }

    public function getOwnerPhoneAttribute()
    {
        return $this->userinfo()->phone;
    }

    public function getOwnerAddressAttribute()
    {
        return $this->userinfo()->address;
    }

    public function getStatusValueAttribute()
    {
        $status = $this->attributes['status'];
        if($status == 1){
            return '待处理';
        }else if($status == 2){
            return '处理中';
        }else if($status == 3){
            return '处理完成';
        }

        return '未知';
    }

    public function getEngineerAttribute()
    {
        $engineer_id = $this->attributes['engineer_id'];
        $userinfo = Userinfo::find($engineer_id);
        if($userinfo){
            return '姓名：'.$userinfo->truename.' 手机号：'.$userinfo->phone;
        }else{
            return '未分配';
        }
    }
}
