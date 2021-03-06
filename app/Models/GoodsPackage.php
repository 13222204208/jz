<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use App\Traits\ImgUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsPackage extends Model
{
    use HasFactory,Timestamp, ImgUrl;
    protected $table ="goods_package";
    protected $guarded = [];

    public function children()//商品
    {
        return $this->belongsToMany('App\Models\Good', 'package_between_goods', 'goods_package_id', 'goods_id');
    }

    
    public function getContentAttribute($value)
    {
        return $this->replaceImgUrl($value);
    }
   

}
