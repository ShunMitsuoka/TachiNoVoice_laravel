<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterApiController;
use App\Http\Controllers\Api\Auth\LoginApiController;
use App\Http\Controllers\Api\Member\MyVillage\CategoryApiController;
use App\Http\Controllers\Api\Member\MyVillage\CoreMemberOpinionApiController;
use App\Http\Controllers\Api\Member\MyVillage\EvaluationApiController;
use App\Http\Controllers\Api\Member\MyVillage\MyVillageApiController;
use App\Http\Controllers\Api\Member\MyVillage\MyVillageMemberApiController;
use App\Http\Controllers\Api\Member\MyVillage\MyVillagePhaseApiController;
use App\Http\Controllers\Api\Member\MyVillage\OpinionApiController;
use App\Http\Controllers\Api\Member\MyVillage\PolicyApiController;
use App\Http\Controllers\Api\Member\MyVillage\RiseMemberOpinionApiController;
use App\Http\Controllers\Api\Member\MyVillage\SatisfactionApiController;
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
use Illuminate\Support\Facades\Auth;

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::apiResource('/member/village', VillageApiController::class);
//     //省略
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// 会員登録
Route::post('/auth/register', [RegisterApiController::class, 'register']);
// 本会員登録
Route::get('/auth/mainRegister', [RegisterApiController::class, 'mainRegister'])->name('auth.mainRegister');
// ログイン
Route::post('/auth/login', [LoginApiController::class, 'Login']);

// ログイン後
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
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

    // 意見一覧
    Route::apiResource('/my/village/{village_id}/opinions', OpinionApiController::class);
    // コアメンバー意見
    Route::apiResource('/my/village/{village_id}/core_member/opinion', CoreMemberOpinionApiController::class);
    // ライズメンバー意見
    Route::apiResource('/my/village/{village_id}/rise_member/opinion', RiseMemberOpinionApiController::class);
    // カテゴリー追加
    Route::apiResource('/my/village/{village_id}/category', CategoryApiController::class);
    // カテゴリー設定
    Route::post('/my/village/{village_id}/opinion/set_category', [OpinionApiController::class, 'setCategory']);
    // 評価登録
    Route::apiResource('/my/village/{village_id}/evaluation', EvaluationApiController::class);
    // 方針登録
    Route::apiResource('/my/village/{village_id}/policy', PolicyApiController::class);
    // 満足度
    Route::apiResource('/my/village/{village_id}/satisfaction', SatisfactionApiController::class);
});
