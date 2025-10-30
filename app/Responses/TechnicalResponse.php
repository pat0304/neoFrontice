<?php

namespace App\Responses;

use App\Models\Technical;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class TechnicalResponse extends BaseResponse
{
    public static function useTechnical(Technical $technical)
    {
        return [
            'name' => $technical->name,
            'icon_link' => Storage::disk('public')->url($technical->icon),
            'color' => $technical->color
        ];
    }
    public static function make(Technical $technical): JsonResponse
    {
        return self::success([
            'name' => $technical->name,
            'icon_link' => Storage::disk('public')->url($technical->icon),
            'color' => $technical->color
        ]);
    }
}
