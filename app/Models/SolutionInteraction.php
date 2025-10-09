<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSolutionInteraction
 */
class SolutionInteraction extends Model
{
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
