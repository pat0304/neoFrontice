<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\Historiable;
use App\Enums\FileUsageEnum;
use Illuminate\Support\Facades\DB;
use App\Responses\TechnicalResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperChallenge
 */
class Challenge extends Model
{

    use HasUuids, Historiable, Sortable;
    public $sortBy = [
        'level_id',
        'user_id',
        'published',
    ];
    public $filterable = [
        'level_id',
        'user_id',
        'published',
    ];
    public $searchable = ['translations' => 'title'];
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
    public function translations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ChallengeTranslate::class);
    }
    public function translation($locale = null)
    {
        $localeRecord = $locale ?? app()->getLocale();
        $translation = $this->translations()->where('locale', $localeRecord)->first();
        if ($translation) {
            return $translation;
        } else {
            return $this->translations()->first();
        }
    }
    public function solutions()
    {
        return $this->hasMany(Solution::class);
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
    public function get(?string $locale = null): array
    {
        $translate = $this->translation($locale);
        $level = $this->level;
        $technicals = [];
        foreach ($this->technicals as $tech) {
            $technicals[] = TechnicalResponse::useTechnical($tech);
        }
        $joined = $this->solutions()->count();
        return
            [
                "id" => $this->id,
                "title" => $translate->title,
                "description" => $translate->desc,
                "shortDecription" => $translate->short_desc,
                "level" => [
                    'name' => $level->name,
                    'required_point' => $level->required_point,
                    'default_point' => $level->default_points,
                ],
                'technicals' => $technicals,
                'joined' => $joined,
                "createdAt" => $this->created_at
            ];
    }

    public static function useCreate(int $level_id, string $locale, string $title,  array $technicals, string $attachment, string $source, string $figma, string $short_desc, ?string $desc = null): self
    {
        $technicals_id = [];
        foreach ($technicals as $tech) {
            $technicals_id[] = Technical::where('name', $tech)->value('id');
        }
        if (empty($technicals_id)) {
            throw new \Exception("Technicals do not valid.", 429);
        }
        $challenge = DB::transaction(function () use ($level_id, $locale, $title, $desc, $short_desc, $technicals_id, $attachment, $source, $figma) {
            $challenge = self::create(
                [
                    'user_id' => auth()->guard()->user()->id,
                    'level_id' => $level_id
                ]
            );

            $challenge->translations()->create(
                [
                    'locale' => $locale,
                    'title' => $title,
                    'desc' => $desc,
                    'short_desc' => $short_desc
                ]
            );
            $challenge->technicals()->attach($technicals_id);
            File::useCreate(auth()->guard()->user(), $attachment, FileUsageEnum::Attachment->value, self::class, $challenge->id, 'public');
            File::useCreate(auth()->guard()->user(), $source, FileUsageEnum::Source->value, self::class, $challenge->id);
            File::useCreate(auth()->guard()->user(), $figma, FileUsageEnum::Figma->value, self::class, $challenge->id);
            return $challenge;
        });
        return $challenge;
    }
    public static function addTranslate(self $challenge, string $locale, string $title, string $short_desc, ?string $desc = null): ChallengeTranslate
    {
        $translate = DB::transaction(function () use ($challenge, $locale, $title, $short_desc, $desc) {
            $challenge->translations()->create(
                [
                    'locale' => $locale,
                    'title' => $title,
                    'short_desc' => $short_desc,
                    'desc' => $desc
                ]
            );
            return $challenge->translation($locale);
        });
        return $translate;
    }
    public function useCast(?string $locale = null)
    {
        $challenge = $this;
        $translate = $challenge->translation($locale);
        $level = $challenge->level;
        $technicals = [];
        foreach ($challenge->technicals as $tech) {
            $technicals[] =    TechnicalResponse::useTechnical($tech);
        }
        $joined = $challenge->solutions()->count();
        return [
            "id" => $challenge->id,
            "title" => $translate->title,
            "description" => $translate->desc,
            "short_decription" => $translate->short_desc,
            'review_photo' => $challenge->attachment,
            "level" => [
                'name' => $level->name,
                'required_point' => $level->required_point,
                'default_point' => $level->default_points,
            ],
            'technicals' => $technicals,
            'joined' => $joined,
            "createdAt" => $challenge->created_at
        ];
    }
    public function useCastForAdmin(?string $locale = null)
    {
        $challenge = $this;
        $translate = $challenge->translation($locale);
        $level = $challenge->level;
        $technicals = [];
        foreach ($challenge->technicals as $tech) {
            $technicals[] =    TechnicalResponse::useTechnical($tech);
        }
        $joined = $challenge->solutions()->count();
        return [
            "id" => $challenge->id,
            "title" => $translate->title,
            "description" => $translate->desc,
            "short_decription" => $translate->short_desc,
            'review_photo' => $challenge->attachment,
            "level" => [
                'name' => $level->name,
                'required_point' => $level->required_point,
                'default_point' => $level->default_points,
            ],
            'technicals' => $technicals,
            'joined' => $joined,
            'published' => $challenge->published,
            "createdAt" => $challenge->created_at
        ];
    }

    public static function useGet(bool $isAdmin = false)
    {
        $challengeModel = new self;
        if ($isAdmin) {
            $challengeModel->where('published', true);
        } else {
            $challengeModel->where('published', false);
        }
        $challenges = $challengeModel->filterByTechnical()->useFilter();
        $data = [];
        foreach ($challenges as $challenge) {
            $data['challenges'][] = $challenge->useCast();
        }
        $data['total'] = $challenges->total();
        $data['currentPage'] = $challenges->currentPage();
        $data['lastPage'] = $challenges->lastPage();
        $data['perPage'] = $challenges->perPage();
        return $data;
    }
    public function scopeFilterByTechnical($query)
    {
        $technical = request()->query('technical', null);
        if ($technical) {
            $query->whereHas('technicals', function ($q) use ($technical) {
                $q->where('name', $technical);
            });
        }
        return $query;
    }
    public function useUpdate(array $array)
    {
        $data = array_filter($array);
        $challenge = DB::transaction(function () use ($data) {
            $this->update($data);
            if (isset($data['locale'])) {
                $translation = $this->translations()->where('locale', $data['locale'])->first();
                if ($translation) {
                    $translation->update([
                        'title' => $data['title'] ?? $translation->title,
                        'short_desc' => $data['short_desc'] ?? $translation->short_desc,
                        'desc' => $data['desc'] ?? $translation->desc,
                    ]);
                } else {
                    $this->translations()->create([
                        'locale' => $data['locale'],
                        'title' => $data['title'],
                        'short_desc' => $data['short_desc'],
                        'desc' => $data['desc'] ?? null,
                    ]);
                }
            }
            if (isset($data['technicals'])) {
                $technicals_id = [];
                foreach ($data['technicals'] as $tech) {
                    $technicals_id[] = Technical::where('name', $tech)->value('id');
                }
                $this->technicals()->sync($technicals_id);
            }
            if (isset($data['attachment'])) {
                $file = $this->files()->where('usage', 'attachment')->first();
                if ($file) {
                    $file->update(['url' => $data['attachment']]);
                } else {
                    File::useCreate(auth()->guard()->user(), $data['attachment'], FileUsageEnum::Attachment->value, self::class, $this->id, 'public');
                }
            }
            if (isset($data['source'])) {
                $file = $this->files()->where('usage', 'source')->first();
                if ($file) {
                    $file->update(['url' => $data['source']]);
                } else {
                    File::useCreate(auth()->guard()->user(), $data['source'], FileUsageEnum::Source->value, self::class, $this->id);
                }
            }
            if (isset($data['figma'])) {
                $file = $this->files()->where('usage', 'figma')->first();
                if ($file) {
                    $file->update(['url' => $data['figma']]);
                } else {
                    File::useCreate(auth()->guard()->user(), $data['figma'], FileUsageEnum::Figma->value, self::class, $this->id);
                }
            }
            return $this;
        });
        return $challenge;
    }
    public function setPublished()
    {
        $this->published = true;
        $this->save();
        if ($this->published) {
            $this->storeHistory('published');
        }
        return $this;
    }
}
