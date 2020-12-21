<?php

namespace App\Models;

use App\Models\Userinfo;
use Jcc\LaravelVote\CanBeVoted;
use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDynamic extends Model
{
    use HasFactory,Timestamp,CanBeVoted;

    protected $vote = Userinfo::class;

    protected $guarded = [];

    protected $appends = ['owner_cover','owner_nickname','like_count'];

    public function userinfo()
    {
        $owner_id = $this->attributes['user_id'];
        $userinfo = Userinfo::find($owner_id);
        return $userinfo;
    }

    public function getOwnerCoverAttribute()
    {
        return $this->userinfo()->cover;
    }

    public function getOwnerNicknameAttribute()
    {
        return $this->userinfo()->nickname;
    }

    public function getLikeCountAttribute()
    {
        $dynamic = UserDynamic::find($this->attributes['id']);
        return $dynamic->countVoters();
    }

}
