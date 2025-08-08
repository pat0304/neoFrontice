<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTaskSolution
 */
class TaskSolution extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'task_id', 'title', 'desc', 'github_url', 'live_page', 'joined_at', 'solved_at', 'is_viewed', 'tasker_review'];
    protected $casts = [
        'joined_at' => 'datetime',
        'solved_at' => 'datetime',
        'is_viewed' => 'boolean',
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
