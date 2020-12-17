<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class BuildBetweenGoods extends Model
{
    use Timestamp;

    protected $table = 'build_between_goods';
    protected $guarded = [];
}
