<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Responses\BaseResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService
{
    private $userService;
    private $emailService;
    private $passwordService;
    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->userService = new UserService();
        $this->emailService = new EmailService();
        $this->passwordService = new PasswordService();
    }
    public function register(RegisterRequest $request)
    {

        $data = $request->validated();
        if (empty($data['email']) || empty($data['password'])) {
            return BaseResponse::error('Email and password are required', 400);
        }
        try {
            DB::beginTransaction();
            $user = $this->userService->createUser($data);
            $this->emailService->create($data['email'], $user);
            $this->passwordService->create($data['password'], $user);
            $token = auth()->guard()->login($user);
            $role = new RoleService($user);
            $role->create($data['role']);
            if (!$token) {
                return false;
            }
            DB::commit();
            return $token;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    /**
     * Handle user login.
     *
     * @param array $credentials
     * @return string|null
     */
    public function login(array $credentials)
    {
        $user = $this->userService->verifyUser($credentials['email'], $credentials['password']);
        if ($user) {
            return auth()->guard()->login($user);
        } else {
            return false;
        }
    }



    /**
     * Get the authenticated user's profile.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function profile()
    {
        return auth()->guard()->user();
    }
}
