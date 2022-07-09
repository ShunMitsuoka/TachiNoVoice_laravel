<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\API\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends BaseApiController
{
    public function Login(Request $request)
    {

        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return $this->makeErrorResponse([]);
        }
        $user = $request->user();
        // $accessToken = $user->createToken('authToken')->accessToken->plainTextToken;
        $accessToken = $user->createToken('authToken')->plainTextToken;
        //$accessToken = $user->createToken('authToken')->accessToken;
        return $this->makeSuccessResponse([
            'user' => $user,
            'access_token' => $accessToken
        ]);
    }
}
