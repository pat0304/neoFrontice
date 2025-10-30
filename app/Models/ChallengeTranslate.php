<?php

namespace App\Models;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperChallengeTranslate
 */
class ChallengeTranslate extends Model
{
    use Historiable;
    protected $fillable = ['challenge_id', 'locale', 'title', 'desc', 'short_desc'];
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
