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
}
