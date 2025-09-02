<?php

namespace App\Http\Controllers\v1\Client\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateRequest;
use App\Responses\BaseResponse;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->update(auth()->guard()->user(), $data);
        return BaseResponse::success($user);
    }
}
