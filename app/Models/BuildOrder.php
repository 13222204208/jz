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
    protected $appends = ['goods_list','engineer_name','engineer_phone'];

    public function userinfo()
    {   
        if($this->attributes['engineer_id'] != 0 ){
            $info= Userinfo::find($this->attributes['engineer_id'],['truename','phone']);
            return $info;
        }
    } 

/*     public function getStatusAttribute($value)
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
    } */

    public function getAgreementIdAttribute($value)//获取合同名称
    {
        $title= Contract::find($value,['title']);
        return $title->title;
    }

/*     public function getEngineerIdAttribute($value)
    {
        if($value != 0){
            $info= Userinfo::find($value,['truename','phone']);
            return $info->truename.','.$info->phone;
        }
    } */

    public function getGoodsListAttribute()
    {
        $goods_id = BuildBetweenGoods::where('build_order_id',$this->attributes['id'])->pluck('goods_id');
        $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','cover','price']);//查询套内商品
        return $ginfo;
    }

    public function getEngineerPhoneAttribute()
    {
        if($this->attributes['engineer_id'] != 0 ){
            return $this->userinfo()->phone;
        }
    } 

    public function getEngineerNameAttribute()
    {
        if($this->attributes['engineer_id'] != 0 ){
            return $this->userinfo()->truename;
        }
    }

}
