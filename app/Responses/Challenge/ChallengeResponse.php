<?php

namespace App\Responses\Challenge;

use App\Models\Challenge;
use App\Responses\BaseResponse;
use App\Responses\TechnicalResponse;

class ChallengeResponse extends BaseResponse
{
    public static function make(Challenge $challenge, ?string $locale = null)
    {
        return self::success($challenge->useCast($locale));
    }
    public static function forAdmin(Challenge $challenge)
    {
        return self::success($challenge->useCastForAdmin());
    }
    public static function download(Challenge $challenge)
    {
        return self::success([
            'source' => $challenge->source,
            'figma' => $challenge->figma
        ]);
    }
}
