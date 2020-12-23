<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinishConstruction extends Model
{
    use HasFactory,Timestamp;
    protected $guarded = [];
}
