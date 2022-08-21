<?php

namespace App\Http\Controllers\Api\Member\Village;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Member\Village\SetSettingRequest;
use App\Http\Requests\Api\Member\Village\SetTopicRequest;

class VillageValidationApiController extends BaseApiController
{
    public function topic(SetTopicRequest $request)
    {
        return $this->makeSuccessResponse([]);
    }

    public function setting(SetSettingRequest $request)
    {
        return $this->makeSuccessResponse([]);
    }
}
