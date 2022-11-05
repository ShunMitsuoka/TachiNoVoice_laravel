<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

            $uuid = Str::uuid();
            $user['uuid'] = $uuid;

            $email = new EmailVerification($user);
            Mail::to($user->email)->send($email);

            User::where('id', $user->id)->update([
                'email_verify_uuid' => $uuid
            ]);
    
            return $this->makeSuccessResponse([
                'user' => $user,
                'accessToken' => $accessToken
            ]);
        } catch (\Throwable $th) {
            return $this->makeErrorResponse([]);
        }
    }

    public function mainRegister(Request $request)
    {
        try {
            $uuid_recode = User::where('deleted_flg', 0)->where('email_verify_uuid', $request->uuid)->exists();
            if ($uuid_recode) {
                User::where('email_verify_uuid', $request->uuid)->update([
                    'email_verified' => now()
                ]);
            }
            else{
                return $this->makeErrorResponse([]);
            }
            return redirect("guest/auth/registerComp"); 
        } catch (\Throwable $th) {
            return $this->makeErrorResponse([]);
        }
    }
}
