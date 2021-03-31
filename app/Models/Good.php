<?php

namespace App\Models;

use App\Models\GoodsType;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Good extends Model
{
    use HasFactory,Timestamp;

    protected $appends= ['quantity'];


    public function getContentAttribute($value)
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        //$url = $http_type.$_SERVER['SERVER_NAME'].'/goods/';
        $url = 'https://wanuzn.com.aa.800123456.top/goods/';
        $pregRule = "/<[img|IMG].*?src=[\‘|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\‘|\"].*?[\/]?>/";
        $list = preg_replace($pregRule, '<img src="'.$url.'${1}" style="max-width:100%">', $value);
        return $list;
    }

    public function getGoodsTypeAttribute($value)
    {
        $goodsType=  GoodsType::find(intval($value),'name');
        return $goodsType->name;
    }

    public function getQuantityAttribute()
    {
        return 1;
    }
    
}
