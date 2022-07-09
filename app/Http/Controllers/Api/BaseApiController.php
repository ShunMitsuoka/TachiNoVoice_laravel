<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected function makeSuccessResponse(array $result, int $status_code = 200) : JsonResponse{
        return ApiResponseService::makeResponse(
            $status_code,
            true,
            $result,
            []
        );
    }
    protected function makeErrorResponse(array $errors, int $status_code = 400) : JsonResponse{
        return ApiResponseService::makeResponse(
            $status_code,
            false,
            [],
            $errors
        );
    }
}
