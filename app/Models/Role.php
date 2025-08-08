<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperRole
 */
class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['role', 'user_id'];
    protected $casts = [
        'user_id' => 'string',
        'role' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
