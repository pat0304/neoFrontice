<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'level_id',
        'user_id',
    ];
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function technicals(){
        return $this->belongsToMany(Technical::class, 'challenge_technicals');
    }
}
