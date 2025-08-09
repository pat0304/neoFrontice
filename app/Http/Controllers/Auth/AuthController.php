<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Responses\BaseResponse;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Responses\User\UserResponse;
use App\Services\Auth\RefreshTokenService;
use Illuminate\Auth\AuthenticationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $authService;
    private $refreshTokenService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService, RefreshTokenService $refreshTokenService)
    {
        $this->authService = $authService;
        $this->refreshTokenService = $refreshTokenService;
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $token =  $this->authService->register($request);
            if (!$token) {
                return BaseResponse::error("Registration failed", 400);
            }
            $cookie = cookie('access_token', $token, 60, null, null, true, true, false, 'Strict');
            return BaseResponse::success(null, "Register Successfully", 201)->cookie($cookie);
        } catch (\Exception $e) {
            return BaseResponse::error($e->getMessage(), 400);
        }
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        try {
            $token = $this->authService->login($data);
            if ($token) {
                $refreshToken = $this->refreshTokenService->create();
                $refreshTokenCookie = cookie('refresh_token', $refreshToken, 60 * 24 * 30, null, null, true, true, false, 'Strict');
                $cookie = cookie('access_token', $token, 60, null, null, true, true, false, 'Strict');
                return BaseResponse::success(null, "Login Successfully")->cookie($cookie)->cookie($refreshTokenCookie);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return UserResponse::make(auth()->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard()->logout();
        $this->refreshTokenService->revoke(request()->cookie('refresh_token'));
        cookie()->forget('access_token');
        cookie()->forget('refresh_token');
        return BaseResponse::success('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        if (request()->cookie('refresh_token')) {
            $refreshToken = request()->cookie('refresh_token');
            $newTokens = $this->refreshTokenService->refresh($refreshToken);
            if (!$newTokens) {
                return BaseResponse::error('Invalid refresh token', 401);
            }
            $cookie = cookie('access_token', $newTokens['access_token'], 60, null, null, true, true, false, 'Strict');
            $refreshTokenCookie = cookie('refresh_token', $newTokens['refresh_token'], 60 * 24 * 30, null, null, true, true, false, 'Strict');
            return BaseResponse::success(null, "Token refreshed successfully")->cookie($cookie)->cookie($refreshTokenCookie);
        }
        return $this->respondWithToken(JWTAuth::refresh());
    }
}
