<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_name' => 'required|max:255',
            'nickname' => 'max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:12|confirmed',
            'password_confirmation' => 'required|min:8|max:12|',
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
            'password_confirmation' => 'パスワード確認用',
            'gender' => '性別',
            'birthyear' => '生年月日-年',
            'birthmonth' => '生年月日-月',
            'birthday' => '生年月日-日',
        ];
    }
}
