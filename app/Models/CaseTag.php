<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class CaseTag extends Model
{
    use Timestamp;
    
    protected $guarded = [];
}
