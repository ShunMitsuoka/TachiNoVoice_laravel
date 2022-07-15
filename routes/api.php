<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegisterApiController;
use App\Http\Controllers\API\Auth\LoginApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\Member\Village\VillageApiController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('/member/village', VillageApiController::class);
    //省略
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 会員登録
Route::post('/auth/register', [RegisterApiController::class, 'register']);
// ログイン
Route::post('/auth/login', [LoginApiController::class, 'Login']);
