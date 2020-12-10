<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBetweenGoods extends Model
{
    use HasFactory;

    protected $table = "package_between_goods";
    
    protected $guarded = [];
}
