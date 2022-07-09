<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\API\BaseApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterApiController extends BaseApiController
{
    public function register(Request $request)
    {
        $user = User::create([
            'user_name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender'    => $request->gender,
            'address'    => 'test',
            'last_login_dt'    => '2020-01-01',
            'date_of_birth' => $request->birthyear . '-' . $request->birthmonth . '-' . $request->birthday,
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return $this->makeSuccessResponse([
            'user' => $user,
            'accessToken' => $accessToken
        ]);
    }
}
