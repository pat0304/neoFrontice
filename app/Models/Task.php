<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTask
 */
class Task extends Model
{
    use \App\Traits\Historiable;
    use HasUuids;
    protected $fillable = ['user_id', 'title', 'desc', 'short_desc', 'required_point', 'start_at', 'expires_at', 'is_paied'];
    protected $keyType = 'string';
    public $incrementing = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function taskSolutions()
    {
        return $this->hasMany(TaskSolution::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function taskTechnicals()
    {
        return $this->belongsToMany(Technical::class, 'task_technicals');
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function getAttachmentAttribute()
    {
        $file = $this->files()->where('usage', 'attachment')->first();
        return $file ? $file->url : null;
    }
    public function getSourceAttribute()
    {
        $file = $this->files()->where('usage', 'source')->first();
        return $file ? $file->url : null;
    }
    public function getFigmaAttribute()
    {
        $file = $this->files()->where('usage', 'figma')->first();
        return $file ? $file->url : null;
    }
}
