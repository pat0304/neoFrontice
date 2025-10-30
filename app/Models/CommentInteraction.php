<?php

namespace App\Models;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCommentInteraction
 */
class CommentInteraction extends Model
{
    use Historiable;
}
