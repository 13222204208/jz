<?php

namespace App\Models;

use App\Models\Contract;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class BuildOrder extends Model
{
    use Timestamp;

    protected $guarded = [];

    public function getStatusAttribute($value)
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
    }

    public function getAgreementIdAttribute($value)//获取合同名称
    {
        $title= Contract::find($value,['title']);
        return $title->title;
    }
}
