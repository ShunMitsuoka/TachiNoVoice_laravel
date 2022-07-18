<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\API\BaseApiController;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterApiController extends BaseApiController
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'user_name' => $request->user_name,
                'nickname' => $request->nickname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender'    => $request->gender,
                'date_of_birth' => $request->birthyear . '-' . $request->birthmonth . '-' . $request->birthday,
            ]);
    
            $accessToken = $user->createToken('authToken')->accessToken;
    
            return $this->makeSuccessResponse([
                'user' => $user,
                'accessToken' => $accessToken
            ]);
        } catch (\Throwable $th) {
            return $this->makeErrorResponse([]);
        }
    }
}
