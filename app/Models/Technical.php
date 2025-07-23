<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    //
    protected $fillable = ['name', 'icon', 'color'];

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'challenge_technicals');
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_technicals');
    }
}
