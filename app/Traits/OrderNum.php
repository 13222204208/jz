<?php

namespace App\Traits;

trait OrderNum
{
    /**
     * @param $num
     * @param $title
     */
    public static function createOrderNum($num, $title)
    {
        $today= date('Y-m-d',time());
        $num = $num+1;
        $number= sprintf ( "%02d",$num);//不足两位带前导0

        $orderNum= $title.date("Ymd",time()).$number;
        return $orderNum;
    }

}
