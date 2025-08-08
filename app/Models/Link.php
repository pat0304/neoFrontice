<?php

namespace App\Models;

use App\Casts\TimestampCast;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLink
 */
class Link extends Model
{

    protected $fillable = ['type', 'user_id', 'title', 'url', 'short_desc'];
    protected $casts = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
