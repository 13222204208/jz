<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory,Timestamp;

     protected $guarded = [];

     public function user()
     {
         return $this->belongsTo('App\Models\Userinfo');
     }

     public function cartItems()
     {
         return $this->hasMany('App\Models\CartItem');
     }
}
