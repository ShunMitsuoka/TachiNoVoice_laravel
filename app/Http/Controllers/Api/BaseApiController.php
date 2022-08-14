<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\User\UserInfo\Gender;

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

    protected function getLoginMember() : Member{
        $user = auth()->user();
        return new Member(
            new UserId($user->id),
            $user->user_name,
            $user->nickname,
            $user->email,
            new Gender($user->gender),
            $user->date_of_birth,
        );
    }
}
