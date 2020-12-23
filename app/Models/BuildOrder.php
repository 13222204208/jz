<?php

namespace App\Models;

use App\Models\Contract;
use App\Models\Userinfo;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuildOrder extends Model
{
    use Timestamp,HasFactory;

    protected $guarded = [];

/*     protected $appends = ['engineer_name','engineer_phone'];

    public function userinfo()
    {
        $user = Userinfo::find(1);
        return $user;
    } */

    public function getStatusAttribute($value)
    {
        switch ($value)
        {
            case 1:
            return '待施工';
            break;  
            case 2:
            return '施工中';
            break;
            case 3:
            return '已完成';
            break;  
            case 4:
            return '已取消';
            break;
            default:$value;
        }
    }

    public function getAgreementIdAttribute($value)//获取合同名称
    {
        $title= Contract::find($value,['title']);
        return $title->title;
    }

    public function getEngineerIdAttribute($value)
    {
        if($value != 0){
            $info= Userinfo::find($value,['truename','phone']);
            return $info->truename.','.$info->phone;
        }
    }
    
/*     public function getEngineerNameAttribute()
    {
        return $this->userinfo()->truename;
    }

    public function getEngineerPhoneAttribute()
    {
        return $this->userinfo()->phone;
    } */
}
