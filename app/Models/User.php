<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\TimestampCast;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Throwable;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasUuids;

    protected $fillable = [
        'id',
        'username',
        'first_name',
        'last_name',
        'provider',
        'provider_id',
        'is_active',
        'is_verified',
        'block_until',
    ];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'username' => 'string',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getPasswordAttribute()
    {
        return $this->passwords()->latest()->value('password');
    }
    public function getEmailAttribute()
    {
        return $this->emails()->latest()->value('email');
    }
    public function getLangAttribute()
    {
        return $this->setting()->value('lang');
    }
    public function routeNotificationForMail($notification)
    {
        return $this->email()->email ?? null;
    }
    public function getRoleAttribute()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->role;
        }
        return $roles;
    }
    public function getMainRoleAttribute()
    {
        return $this->roles()->where('main', true)->first()->role;
    }
    public function getLinksAttribute()
    {
        $links = [];
        foreach ($this->links as $link) {
            $links[] = [
                'id' => $link->id,
                'name' => $link->name,
                'url' => $link->url,
            ];
        }
    }


    // RELATIONSHIPS - hasOne
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
    public function taskee()
    {
        return $this->hasOne(Taskee::class, 'id', 'id');
    }
    public function tasker()
    {
        return $this->hasOne(Tasker::class, 'id', 'id');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'id');
    }

    // RELATIONSHIPS - Has Many
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }
    public function emails()
    {
        return $this->hasMany(Email::class);
    }
    public function passwords()
    {
        return $this->hasMany(Password::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function commentInteractions()
    {
        return $this->hasMany(CommentInteraction::class);
    }


    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function links()
    {
        return $this->hasMany(Link::class);
    }
    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }
    public function taskSolutions()
    {
        return $this->hasMany(TaskSolution::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // RELATIONSHIPS - Belongs To Many
    public function solutionInteractions()
    {
        return $this->belongsToMany(Solution::class, 'solution_interactions')
            ->withPivot('interact')
            ->withTimestamps();
    }
    // RELATIONSHIPS - MORPHABLE
    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }
    public function getAvatarAttribute()
    {
        $file = $this->files()->where('usage', 'avatar')->first();
        return $file ? $file->url : null;
    }
    public function getCvAttribute()
    {
        $file = $this->files()->where('usage', 'cv')->first();
        return $file ? $file : null;
    }

    //CUSTOM Function
    public function useUpdate(array $array)
    {
        DB::transaction(function () use ($array) {
            $active_role = request()->get('active_role');

            $this->update($array);
            $this[$active_role]->update($array);
            return $this;
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            Setting::create([
                "user_id" => $model->id
            ]);
        });
    }
}
