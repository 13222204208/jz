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
        $role_id = $this->attributes['role_id'];
        if($role_id == 1){
            return '业主';
        }

        if($role_id == 2){
            return '商家';
        }

        if($role_id == 3){
            return '工程师';
        }
    }

    public function getSexAttribute($value)
    {
        if($value == 1){
            return '男';
        }else{
            return '女';
        }
    }
}
