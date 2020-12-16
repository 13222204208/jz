<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class AfterSale extends Model
{
    use Timestamp;

    protected $table = 'after_sale';
    
    protected $guarded = [];
}
