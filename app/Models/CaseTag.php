<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class CaseTag extends Model
{
    use Timestamp;
    
    protected $guarded = [];

    public function getContentAttribute($value)
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        //$url = $http_type.$_SERVER['SERVER_NAME'].'/goods/';
        $url = 'https://wanuzn.com.aa.800123456.top/content/';
        $pregRule = "/<[img|IMG].*?src=[\‘|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\‘|\"].*?[\/]?>/";
        $list = preg_replace($pregRule, '<img src="'.$url.'${1}" style="max-width:100%">', $value);
        return $list;
    }
}
