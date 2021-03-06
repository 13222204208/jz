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
    protected $appends = ['goods_list','engineer_name','engineer_phone','owner_cover','goods_list_name','company','contract_id'];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract','id','agreement_id');
    }

    public function userinfo()
    {   
        if($this->attributes['engineer_id'] != 0 ){
            $info= Userinfo::find($this->attributes['engineer_id'],['truename','phone','cover']);
            return $info;
        }
    } 

    
    public function getContractIdAttribute()
    {
        return $this->attributes['agreement_id']; 
    }
    
    public function getAgreementIdAttribute($value)//获取合同名称
    {
        if($value == 0 ){
            return null;
        }
        $title= Contract::find($value,['title']);
        if($title){
            return $title->title;
        }
        return null;
    }

    public function getCompanyAttribute($value)
    {
        if($this->attributes['merchant_id'] == 0 ){
            return null;
        }
     
        $company= Userinfo::find($this->attributes['merchant_id'],['company']);
        if($company){
            return $company->company;
        }
        return null;
    }

    public function getGoodsListNameAttribute()
    {
        return "安防套餐";
    } 

    public function getGoodsListAttribute()
    {
        $goods_id = BuildBetweenGoods::where('build_order_id',$this->attributes['id'])->pluck('goods_id');
        $ginfo= Good::whereIn('id',$goods_id)->get(['id','title','description','cover','price','goods_type']);//查询套内商品
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

    public function getOwnerCoverAttribute()
    {
        $phone = $this->attributes['owner_phone'];
        $cover = Userinfo::where('phone',$phone)->pluck('cover')->first();
        return $cover;
    }


}
