<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class BaseResponse
{
    public static function success($data = null, $message = 'Success', $code = 200): JsonResponse
    {
        if (is_null($data)) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ], $code);
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public static function error($message = 'Error', $code = 400, $data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
    public static function unauthorized($data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('messages.unauthorized'),
        ], 401);
    }
    public static function notFound($data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('messages.not_found'),
        ], 404);
    }
}
