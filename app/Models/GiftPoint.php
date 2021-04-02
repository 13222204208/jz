<?php

namespace App\Models;

use App\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftPoint extends Model
{
    use HasFactory, Timestamp;
    protected $guarded = [];
}
