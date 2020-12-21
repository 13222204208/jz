<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnderConstruction extends Model
{
    use HasFactory,Timestamp;
    protected $guarded = [];
}
