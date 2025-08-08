<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperComment
 */
class Comment extends Model
{
    use HasUuids;
    protected $fillable = [
        'user_id',
        'is_admin_feedback',
        'commentable_type',
        'commentable_id',
        'content',
        'parent_id',
        'left',
        'right',
        'is_deleted',
        'is_updated',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function interactions()
    {
        return $this->hasMany(CommentInteraction::class);
    }
}
