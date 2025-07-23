<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasUuids;
    protected $fillable = ['user_id', 'title', 'desc', 'short_desc', 'required_point', 'start_at', 'expires_at', 'is_paied'];
    protected $keyType = 'string';
    public $incrementing = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function taskSolutions(){
        return $this->hasMany(TaskSolution::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function taskTechnicals(){
        return $this->belongsToMany(Technical::class, 'task_technicals');
    }
}
