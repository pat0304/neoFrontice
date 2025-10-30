<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReport
 */
class Report extends Model
{
    use \App\Traits\Historiable;
    protected $fillable = ['user_id', 'reportable_type', 'reportable_id', 'reason', 'message', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
