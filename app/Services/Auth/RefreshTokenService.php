<?php

namespace App\Services\Auth;

use App\Models\RefreshToken;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class RefreshTokenService
{
    public function create()
    {
        $token = Str::random(64);
        $refreshToken = RefreshToken::create([
            'user_id' => auth()->guard()->user()->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent') ?? 'unknown',
            'token' => Hash::make($token),
            'revoked' => false,
            'expires_at' => now()->addDays(30),
        ]);
        return $token;
    }

    /**
     * Refresh the access token using the refresh token.
     *
     * @param string $refreshToken
     * @return null|array{
     * access_token: string,
     * refresh_token: string,
     * }
     */
    public function refresh($refreshToken): ?array
    {
        $refreshTokenRecord = RefreshToken::where('revoked', false)
            ->where('user_agent', request()->header('User-Agent') ?? 'unknown')
            ->where('expires_at', '>', now())->get()
            ->first(function ($token) use ($refreshToken) {
                return Hash::check($refreshToken, $token->token);
            });

        if (!$refreshTokenRecord) {
            return null;
        }
        $user = $refreshTokenRecord->user;
        if (!$user) {
            return null;
        }
        $token = JWTAuth::getToken() ?? null;
        if ($token && JWTAuth::setToken($token)->check()) {
            JWTAuth::invalidate($token);
        }
        $newToken = auth()->guard()->login($user);
        $newRefreshToken = $this->create();
        $refreshTokenRecord->revoked = true;
        $refreshTokenRecord->save();
        return [
            'access_token' => $newToken,
            'refresh_token' => $newRefreshToken,
        ];
    }

    public function revoke($refreshToken)
    {
        $refreshTokenRecord = RefreshToken::where('revoked', false)
            ->where('user_id', auth()->guard()->user()->id)
            ->where('user_agent', request()->header('User-Agent') ?? 'unknown')
            ->where('expires_at', '>', now())->get()->first(function ($token) use ($refreshToken) {
                return Hash::check($refreshToken, $token->token);
            });

        if (!$refreshTokenRecord) {
            return false;
        }
        $refreshTokenRecord->revoked = true;
        $refreshTokenRecord->save();
        return true;
    }
}
