<?php

namespace App\Exceptions;

use Throwable;
use App\Responses\BaseResponse;
use AWS\CRT\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            // Lỗi xác thực
            if ($e instanceof AuthenticationException) {
                return BaseResponse::unauthorized();
            }

            // Lỗi không tìm thấy model
            if ($e instanceof ModelNotFoundException) {
                return BaseResponse::notFound();
            }

            // Lỗi không tìm thấy route
            if ($e instanceof NotFoundHttpException) {
                return BaseResponse::error(__('messages.route_not_found'), 404);
            }

            // Lỗi giới hạn request
            if ($e instanceof ThrottleRequestsException) {
                return BaseResponse::error(__('messages.too_many_requests'), 429);
            }

            // Lỗi validate
            if ($e instanceof ValidationException) {
                return BaseResponse::error(__('messages.validation_error'), 422, $e->errors());
            }
            if ($e instanceof AuthorizationException) {
                return BaseResponse::forbidden($e->getMessage());
            }
            if ($e instanceof AccessDeniedHttpException) {

                $previous = $e->getPrevious();
                $message = $previous?->getMessage() ?: __('messages.forbidden');

                return BaseResponse::forbidden($message);
            }

            return BaseResponse::error(__('messages.internal_server_error'), 500);
        });
    }
}
