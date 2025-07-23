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
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

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
        'block_until',
    ];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'is_active' => 'boolean',
        'block_until' => TimestampCast::class,
        'created_at' => TimestampCast::class,
        'updated_at' => TimestampCast::class,
        'deleted_at' => TimestampCast::class,
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
    public function password()
    {
        return $this->passwords()->latest()->first();
    }
    public function email()
    {
        return $this->emails()->where("is_active", true)->latest()->first();
    }

    // RELATIONSHIPS - hasOne
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
    public function taskee()
    {
        return $this->hasOne(Taskee::class);
    }
    public function tasker()
    {
        return $this->hasOne(Tasker::class);
    }
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    // RELATIONSHIPS - Has Many
    public function roles()
    {
        return $this->hasMany(Role::class);
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
    public function solutionsInteractions()
    {
        return $this->hasMany(SolutionInteraction::class);
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



    // RELATIONSHIPS - MORPHABLE
    public function schedules()
    {
        return $this->morphMany(Schedule::class, 'scheduleable');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         if (empty($model->id)) {
    //             $model->id = \Illuminate\Support\Str::uuid();
    //         }
    //     });
    // }
}
