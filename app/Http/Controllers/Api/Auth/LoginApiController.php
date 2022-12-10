<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Mail\NextPhaseEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $accessToken = $user->createToken('authToken')->plainTextToken;
        return $this->makeSuccessResponse([
            'user' => $user,
            'is_verified' => $user->hasVerifiedEmail(),
            'access_token' => $accessToken
        ]);
    }
}
