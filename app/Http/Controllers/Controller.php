<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Responses\BaseResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Gate;

abstract class Controller extends BaseController
{
    use \Illuminate\Foundation\Bus\DispatchesJobs, \Illuminate\Foundation\Validation\ValidatesRequests;

    public function authorize($ability, $arguments = [])
    {
        try {
            return app(Gate::class)->authorize($ability, $arguments);
        } catch (AuthorizationException $e) {
            abort(BaseResponse::forbidden(
                $e->getMessage() ?: 'forbidden'
            ));
        }
    }
}
