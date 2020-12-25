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

    /**
     * 一篇文章有多个评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 获取这篇文章的评论以parent_id来分组
     * @return static
     */
    public function getComments()
    {
        return $this->comments()->with(['owner'=>function($query){
            $query->select('id','role_id','cover','nickname');
        }])->get(['id','parent_id','content','userinfo_id','created_at'])->groupBy('parent_id');
    }

}
