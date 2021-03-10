<?php

namespace App\Models;

use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntegralExchange extends Model
{
    use HasFactory, Timestamp;

    public function nickName()
    {
        return $this->hasOne('App\Models\Userinfo', 'id','user_id');
    }
}
