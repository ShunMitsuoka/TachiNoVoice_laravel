<?php

namespace App\Http\Requests\Api\Member\Village;

use App\Http\Requests\Api\BaseApiRequest;

class SetSettingRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'village_member_limit' => 'required|integer|min:1|max:500',
            'core_member_limit' => 'required|integer|min:1|max:100',
            'requirement' => 'max:5000'
        ];
    }

    public function attributes()
    {
        return [
            'village_member_limit' => 'ビレッジメンバー定員数',
            'core_member_limit' => 'コアメンバー定員数',
            'requirement' => 'ビレッジ参加条件'
        ];
    }
}
