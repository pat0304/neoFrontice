<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperChallenge
 */
class Challenge extends Model
{
    use HasUuids;
    protected $with = ['translations'];
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
    public function technicals()
    {
        return $this->belongsToMany(Technical::class, 'challenge_technicals');
    }
    public function translations()
    {
        return $this->hasMany(ChallengeTranslate::class);
    }
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $translation = $this->translations->where('locale', $locale)->first();
        if ($translation) {
            return $translation;
        } else {
            return $this->translations->first();
        }
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
