<?php

namespace App\Models;

use App\Models\ContractPackage;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use Timestamp,HasFactory;

    protected $guarded = [];

    public function contractPackage()
    {
        return $this->hasMany('App\Models\ContractPackage');
    }
}
