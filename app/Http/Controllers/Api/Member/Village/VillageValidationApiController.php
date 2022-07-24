<?php

namespace App\Http\Controllers\Api\Member\Village;

use App\Http\Controllers\API\BaseApiController;
use App\Http\Requests\Api\Member\Village\SetTopicRequest;

class VillageValidationApiController extends BaseApiController
{
    public function topic(SetTopicRequest $request)
    {
        return $this->makeSuccessResponse([]);
    }
}
