<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractPackage extends Model
{
    use HasFactory;
    use Timestamp;
    
    protected $guarded = [];

    public function goodsPackage()
    {
        return $this->belongsTo('App\Models\GoodsPackage');
    }
}
