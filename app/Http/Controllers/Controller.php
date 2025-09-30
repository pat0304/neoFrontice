<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Responses\BaseResponse;

abstract class Controller extends BaseController
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests, \Illuminate\Foundation\Bus\DispatchesJobs, \Illuminate\Foundation\Validation\ValidatesRequests;
}
