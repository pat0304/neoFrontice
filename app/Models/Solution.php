<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSolution
 */
class Solution extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'challenge_id', 'title', 'desc', 'github_url', 'live_page', 'joined_at', 'solved_at'];
    protected $casts = [
        'joined_at' => 'datetime',
        'solved_at' => 'datetime',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
    public function solutionInteractions()
    {
        return $this->belongsToMany(User::class, 'solution_interactions')
            ->withPivot('interact')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
