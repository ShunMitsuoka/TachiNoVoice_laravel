<?php

namespace App\Http\Requests\Api\Member;

use App\Http\Requests\Api\BaseApiRequest;


class UserSettingRequest extends BaseApiRequest
{
    public function rules()
    {
        return [
            'user_name' => 'required|max:255',
            'nickname' => 'max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId . ',id',
            'password' => 'max:12',
            'gender' => 'required|integer',
            'birthyear' => 'required|integer',
            'birthmonth' => 'required|integer',
            'birthday' => 'required|integer',
        ];
    }
    public function attributes()
    {
        return [
            'user_name' => '氏名',
            'nickname' => 'ニックネーム',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'gender' => '性別',
            'birthyear' => '生年月日-年',
            'birthmonth' => '生年月日-月',
            'birthday' => '生年月日-日',
        ];
    }
}
