<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsPackage extends Model
{
    use HasFactory,Timestamp;
    protected $table ="goods_package";
    protected $guarded = [];

    public function children()//商品
    {
        return $this->belongsToMany('App\Models\Good', 'package_between_goods', 'goods_package_id', 'goods_id');
    }

    
    public function getContentAttribute($value)
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        //$url = $http_type.$_SERVER['SERVER_NAME'].'/goods/';
        $url = 'https://wanuzn.com.aa.800123456.top/goods/';
        $pregRule = "/<[img|IMG].*?src=[\‘|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\‘|\"].*?[\/]?>/";
        $list = preg_replace($pregRule, '<img src="'.$url.'${1}" style="max-width:100%">', $value);
        return $list;
    }
   

}
