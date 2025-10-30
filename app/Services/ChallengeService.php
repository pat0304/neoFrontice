<?php

namespace App\Services;

use App\Models\Challenge;
use App\Responses\BaseResponse;

class ChallengeService
{
    public function getAll()
    {
        $challenges = Challenge::useGet();
        return $challenges;
    }
    public function getChallenge(string $id)
    {
        $challenge = Challenge::find($id);
        if ($challenge) {
            return $challenge;
        } else {
            abort(BaseResponse::notFound());
        }
    }
    public function create(array $data)
    {
        $challenge = Challenge::useCreate($data['level_id'], $data['locale'], $data['title'], $data['technicals'], $data['attachment'], $data['source'], $data['figma'], $data['short_desc'], $data['desc']);
        return $challenge;
    }
    public function addTranslation(Challenge $challenge, array $data)
    {
        $isExists = $challenge->translations()->where('locale', $data['locale'])->exists();
        if (!$isExists) {
            $translate = Challenge::addTranslate($challenge, $data['locale'], $data['title'], $data['short_desc'], $data['desc']);
            return $translate;
        } else {
            abort(BaseResponse::error(__('messages.exists', ['attribute' => 'Locale']), 429));
        }
    }
    public function update(string $id, $array)
    {
        $challenge = Challenge::find($id);
        if (!$challenge) {
            abort(BaseResponse::notFound());
        }
        $challenge->useUpdate($array);
        return $challenge;
    }
    public function published(string $challenge_id)
    {
        $challenge = $this->getChallenge($challenge_id);
        $challenge->setPublished();
        return $challenge;
    }
}
