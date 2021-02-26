<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integral extends Model
{
    use HasFactory;
    use Timestamp;
    
    protected $guarded = [];
}
