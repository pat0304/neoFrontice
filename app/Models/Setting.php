<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSetting
 */
class Setting extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'lang', 'notifiable_comment', 'notifiable_comment_replied', 'notifiable_solution_like', 'notifiable_for_archievement'];

    protected $keyType = 'string';
    public $primaryKey = 'user_id';
    public $incrementing = false;
    protected $casts = [
        'user_id' => 'string',
        'notifiable_comment' => 'boolean',
        'notifiable_comment_replied' => 'boolean',
        'notifiable_solution_like' => 'boolean',
        'notifiable_for_archievement' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
