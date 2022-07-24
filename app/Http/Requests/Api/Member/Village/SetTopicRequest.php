<?php

namespace App\Http\Requests\Api\Member\Village;

use App\Http\Requests\Api\BaseApiRequest;

class SetTopicRequest extends BaseApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'max:5000',
            'note' => 'max:5000'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'content' => '説明',
            'note' => '注意事項'
        ];
    }
}
