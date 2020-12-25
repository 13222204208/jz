<?php
namespace App\Models;

use Jcc\LaravelVote\Vote;
use App\Models\Traits\Timestamp;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Userinfo extends Authenticatable implements JWTSubject {

    use Notifiable,HasFactory,Timestamp,Vote;

    protected $table = 'userinfo';
    protected $guarded = [];
    protected $appends = ['role_name'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function getRoleNameAttribute()
    {
        $owner = $this->attributes['is_owner'];
        $seller = $this->attributes['is_seller'];
        $engineer = $this->attributes['is_engineer'];

        $roleName = '';
        if($owner== 1){
            $roleName .= '业主'.',';
        }

        if($seller == 1){
            $roleName .= '商家'.',';
        }

        if($engineer == 1){
            $roleName .= '工程师'.',';
        }

        return rtrim($roleName,',');
    }

}
