<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['role', 'user_id'];
    protected $casts = [
        'user_id' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
