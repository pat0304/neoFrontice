<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Responses\BaseResponse;
use App\Services\Auth\EmailService;
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
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    public function verifyEmailByToken(Request $request)
    {
        // Logic to verify the email address
        // This could involve checking a token or code sent to the user's email
        $email = $this->emailService->verifyEmailByToken($request->input('token'));
        if (!$email) {
            return BaseResponse::error('Invalid or expired token', 400);
        }
        return BaseResponse::success($email, 'Email verified successfully');
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
