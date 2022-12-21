<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class MakeHashController extends Controller
{
    public function makeHash (Request $request) 
    {
        $password = $request->password;
        Log::info('ログサンプル', ['memo' => $password]);
        $hash_password = Hash::make($password);
        return Redirect::back()->with('message',$hash_password);
    }
}
