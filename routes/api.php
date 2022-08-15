<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegisterApiController;
use App\Http\Controllers\API\Auth\LoginApiController;
use App\Http\Controllers\Api\Member\MyVillage\CoreMemberOpinionApiController;
use App\Http\Controllers\Api\Member\MyVillage\MyVillageApiController;
use App\Http\Controllers\Api\Member\MyVillage\MyVillageMemberApiController;
use App\Http\Controllers\Api\Member\MyVillage\MyVillagePhaseApiController;
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
use App\Http\Controllers\Api\Member\Village\VillageValidationApiController;
// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::apiResource('/member/village', VillageApiController::class);
//     //省略
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// 会員登録
Route::post('/auth/register', [RegisterApiController::class, 'register']);
// ログイン
Route::post('/auth/login', [LoginApiController::class, 'Login']);
// ログイン後
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/village', VillageApiController::class);
    Route::post('/village/join', [VillageApiController::class, 'join']);
    // ビレッジ登録時バリデーション
    Route::post('/village/register/validation/topic', [VillageValidationApiController::class, 'topic']);
    Route::post('/village/register/validation/setting', [VillageValidationApiController::class, 'setting']);
    // ビレッジ詳細
    Route::apiResource('/my/village', MyVillageApiController::class);
    // ビレッジフェーズ処理
    Route::post('/my/village/{id}/phase/start', [MyVillagePhaseApiController::class, 'start']);
    Route::post('/my/village/{id}/phase/next', [MyVillagePhaseApiController::class, 'next']);
    Route::post('/my/village/{id}/phase/setting', [MyVillagePhaseApiController::class, 'setting']);
    // ビレッジメンバー
    Route::get('/my/village/{id}/members/', [MyVillageMemberApiController::class, 'show']);
    // コアメンバー意見
    Route::apiResource('/my/village/{village_id}/core_member/opinion', CoreMemberOpinionApiController::class);
});

