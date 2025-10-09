<?php

namespace App\Http\Controllers\v1\Auth;

use App\Eloquents\PasswordEloquent;
use App\Http\Controllers\Controller;
use App\Responses\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    protected PasswordEloquent $passwordService;
    public function __construct(PasswordEloquent $passwordEloquent)
    {
        $this->passwordService = $passwordEloquent;
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('password');

        $user = auth()->user();
        $result = $this->passwordService->changePassword($user, $currentPassword, $newPassword);
        if (!$result) {
            return BaseResponse::error(__("messages.data_invalid"), 400);
        }
        return BaseResponse::success(__("messages.success"));
    }
    public function sendMailVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->input('email');
        $this->passwordService->sendResetLink($email);
        return BaseResponse::success(__("messages.success"));
        return BaseResponse::error();
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $token = $request->query('token');
        $newPassword = $request->input('password');
        $this->passwordService->resetPasswordByLink($token, $newPassword);
        return BaseResponse::success();
    }
}
