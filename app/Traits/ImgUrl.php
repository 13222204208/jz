<?php

namespace App\Traits;

trait ImgUrl
{
    public static function replaceImgUrl($content)
    {

        $url = self::currentUrl();
     
        $pregRule = "/<[img|IMG].*?src=[\‘|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\‘|\"].*?[\/]?>/";
        $list = preg_replace($pregRule, '<img src="'.$url.'${1}" style="max-width:100%">', $content);
        return $list;
    }

        
    public static function currentUrl()
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        $url = $http_type.$_SERVER['HTTP_HOST'].'/goods/';

        return $url;
    }

    public static function delImgUrl($content)
    {
        return str_replace('src="'.self::currentUrl(),'src="',$content);//匹配图片地址
    }
}
