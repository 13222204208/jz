<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Design extends Model
{
    use HasFactory;
    use Timestamp;
    
    protected $guarded = [];

    public function getHouseTypeAttribute($value)
    {
        $name= HouseType::find(intval($value),'name');
        return $name->name;
    }

    public function getGoodsTypeAttribute($value)
    {
        $name= GoodsType::find(intval($value),'name');
        return $name->name;
    }
}
