<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;


class LoginApiController extends BaseApiController
{
    public function Login(LoginRequest $request)
    {

        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return $this->makeErrorResponse([]);
        }
        $user = $request->user();

        if (is_null($user->email_verified)) {
            return $this->makeErrorResponse([]);
        }
        // $accessToken = $user->createToken('authToken')->accessToken->plainTextToken;
        $accessToken = $user->createToken('authToken')->plainTextToken;
        //$accessToken = $user->createToken('authToken')->accessToken;
        return $this->makeSuccessResponse([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }
}
