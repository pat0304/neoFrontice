<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCommentInteraction
 */
class CommentInteraction extends Model
{

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
