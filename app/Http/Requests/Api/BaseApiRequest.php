<?php

namespace App\Http\Requests\Api;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BaseApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $res = ApiResponseService::makeResponse(
            422,
            false,
            [],
            $validator->errors()
        );
        throw new HttpResponseException($res);
    }
}
