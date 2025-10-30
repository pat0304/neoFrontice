<?php

namespace App\Http\Controllers\v1\Admin\Challenge;

use App\Http\Controllers\Controller;
use App\Http\Requests\Challenge\ChallengeCreateRequest;
use App\Http\Requests\Challenge\ChallengeUpdateRequest;
use App\Http\Requests\Challenge\TranslateCreateRequest;
use App\Models\Challenge;
use App\Responses\Challenge\ChallengeResponse;
use App\Services\ChallengeService;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    private $challengeService;
    public function __construct(ChallengeService $challengeService)
    {
        $this->challengeService = $challengeService;
    }
    public function getAll()
    {
        return ChallengeResponse::success($this->challengeService->getAll());
    }
    public function get(string $id)
    {
        $challenge = $this->challengeService->getChallenge($id);
        return ChallengeResponse::make($challenge);
    }
    public function create(ChallengeCreateRequest $request)
    {
        $this->authorize('create', Challenge::class);
        $data = $request->validated();
        $challenge =  $this->challengeService->create($data);
        return ChallengeResponse::make($challenge);
    }
    public function add(TranslateCreateRequest $request, $id)
    {
        $data = $request->validated();
        $challenge = $this->challengeService->getChallenge($id);
        $this->authorize('update', $challenge);
        $this->challengeService->addTranslation($challenge, $data);
        return ChallengeResponse::make($challenge, $data['locale']);
    }
    public function update(ChallengeUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $challenge = $this->challengeService->getChallenge($id);
        $this->authorize('update', $challenge);
        $this->challengeService->update($id, $data);
        $locale = $data['locale'] ?? null;
        return ChallengeResponse::make($challenge, $locale);
    }
    public function published(string $id)
    {
        $challenge = $this->challengeService->getChallenge($id);
        $this->authorize('update', $challenge);
        $challenge = $this->challengeService->published($id);
        return ChallengeResponse::make($challenge);
    }
}
