<?php

namespace App\Models;

use App\Models\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    use Timestamp;
    
    protected $guarded = [];
    protected $appends = ['owner_cover','owner_nickname'];

    public function userinfo()
    {
        $owner_id = $this->attributes['userinfo_id'];
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

    /**
     * 这个评论的所属用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Userinfo::class, 'userinfo_id');
    }

    /**
     * 这个评论的子评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
