<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperChallengeTranslate
 */
class ChallengeTranslate extends Model
{

    protected $fillable = ['challenge_id', 'locale', 'title', 'desc', 'short_desc'];
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
