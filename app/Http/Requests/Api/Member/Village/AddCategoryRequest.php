<?php

namespace App\Http\Requests\Api\Member\Village;

use App\Http\Requests\Api\BaseApiRequest;

class AddCategoryRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'category' => 'required|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'category' => 'カテゴリー',
        ];
    }
}
