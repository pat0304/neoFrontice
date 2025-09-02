<?php

namespace App\Http\Controllers\Auth;

use App\Eloquents\EmailEloquent;
use App\Http\Controllers\Controller;
use App\Responses\BaseResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    private $emailService;
    /**
     * Handle the incoming request to verify email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct(EmailEloquent $EmailEloquent)
    {
        $this->emailService = $EmailEloquent;
    }
    public function verifyEmailByToken(Request $request)
    {
        $email = $this->emailService->verifyEmailByToken($request->input('token'));
        if (!$email) {
            return BaseResponse::error('Invalid or expired token', 400);
        }
        return BaseResponse::success();
    }
    public function verifyEmailByOTP(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|size:6'
        ]);
        $email = $this->emailService->verifyEmailByToken($request['otp_code']);
        if (!$email) {
            return BaseResponse::error('Invalid or expired OTP', 400);
        }
        return BaseResponse::success();
    }
    public function sendMail()
    {
        try {
            $this->emailService->sendMail(auth()->guard()->user()->email);
            return BaseResponse::success(null, 'Verification email sent successfully');
        } catch (\Exception $e) {
            return BaseResponse::error('Failed to send verification email: ' . $e->getMessage(), 400);
        }
    }
}
