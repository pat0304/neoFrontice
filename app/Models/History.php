<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperHistory
 */
class History extends Model
{
    protected $fillable = ['user_id', 'history_type', 'history_id', 'action'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historyable()
    {
        return $this->morphTo();
    }
}