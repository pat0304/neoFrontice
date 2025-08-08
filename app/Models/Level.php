<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLevel
 */
class Level extends Model
{
    protected $fillable = ['name', 'default_points', 'require_points', 'icon', 'background', 'color'];

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}
