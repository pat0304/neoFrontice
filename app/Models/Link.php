<?php

namespace App\Models;

use App\Casts\TimestampCast;
use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLink
 */
class Link extends Model
{
    use Historiable;
    protected $fillable = ['type', 'user_id', 'title', 'url', 'short_desc'];
    protected $casts = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
