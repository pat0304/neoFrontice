<?php

namespace App\Models;

use App\Responses\BaseResponse;
use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @mixin IdeHelperPassword
 */
class Password extends Model
{
    use HasUuids, Historiable;
    protected $fillable = ['id', 'user_id', 'password', 'hash_algorithm', 'otp_code', 'token', 'is_verified', 'otp_sent_at', 'expires_at'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'is_verified' => 'boolean'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function useCreate(string $password, User $user,  string $hash_algorithm = 'bcrypt')
    {
        $passwordModel = $user->passwords();
        $isTrue = ($passwordModel->count() > 0);
        if (($isTrue)) {
            foreach ($passwordModel->get() as $item) {
                if (Hash::check($password, $item->password)) {
                    abort(BaseResponse::error(__('messages.password_already_used'), 422));
                }
            }
        }
        $new = $passwordModel->create([
            'user_id' => $user->id,
            'password' => bcrypt($password),
            'hash_algorithm' => $hash_algorithm
        ]);
        return $new;
    }
    public function setPassword(string $password, string $hash_algorithm = 'bcrypt')
    {
        return self::useCreate($password, $this->user, $hash_algorithm);
    }
}
