<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterApiController extends BaseApiController
{
    public function register(RegisterRequest $request)
    {
        try {
            event(new Registered($user = User::create([
                'user_name' => $request->user_name,
                'nickname' => $request->nickname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender'    => $request->gender,
                'date_of_birth' => $request->birthyear . '-' . $request->birthmonth . '-' . $request->birthday,
            ])));
    
            $accessToken = $user->createToken('authToken')->accessToken;

            $uuid = Str::uuid();
            $user['uuid'] = $uuid;

            // $user->SendEmailVerificationNotification();

            // if ($user->fill($request->all())->save()) {
            // メール確認の為の仮登録完了メール送信
            // event(new Registered($user));
            // }
            // $email = new EmailVerification($user);
            // Mail::to($user->email)->send($email);

            // User::where('id', $user->id)->update([
            //     'email_verify_uuid' => $uuid
            // ]);
    
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
            $user = User::where('deleted_flg', 0)->where('id', $request->id)->exists();
            if ($user) {
                User::where('id', $request->id)->update([
                    'email_verified' => now()
                ]);
            }
            else{
                return $this->makeErrorResponse([]);
            }
            $url = "http://localhost";
            if (app()->isProduction()) {
                $url = "https://tachi-no-voice.com";
            }
            return redirect($url."/guest/auth/registerComp"); 
        } catch (\Throwable $th) {
            return $this->makeErrorResponse([]);
        }
    }
}
