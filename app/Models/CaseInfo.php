<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaseInfo extends Model
{
    use Timestamp;
    
    protected $guarded = [];

    public function getTypeAttribute($value)//类型
    {
        if($value =='case'){
            return '案例';
        }else if($value == 'info'){
            return '资讯';
        }
    } 

    public function getTagAttribute($value)//案例的标签
    {
        if($value != ''){
            $data = explode(',',$value);

            $str ="";
            foreach($data as $d){
                $tag = CaseTag::find(intval($d));
                $str .= $tag->name.',';
            }
    
            return rtrim($str,',');
        }

    } 

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
