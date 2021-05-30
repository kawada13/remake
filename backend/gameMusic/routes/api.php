<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// 認証関連
Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('register');
Route::post('/logout', 'AuthController@logout')->name('logout');

// マスターテーブル関連
Route::get('/sound_type/sound', 'SoundTypeController@sound')->name('type.sound');
Route::get('/sound_type/understanding', 'SoundTypeController@understanding')->name('type.understanding');
Route::get('/sound_type/use', 'SoundTypeController@use')->name('type.use');
Route::get('/sound_type/instrument', 'SoundTypeController@instrument')->name('type.instrument');

// 特定のオーディオ取得
Route::get('/audio/{id}/show', 'AudioController@audioShow')->name('audio.show');
// 検索オーディオ取得
Route::post('/audios', 'AudioController@audioSearchIndex')->name('audio.index');




Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ユーザー情報取得
    Route::get('/user_information', 'UserController@loginUserInformation')->name('loginUserInformation');
    // ユーザープロフィール編集
    Route::post('/user_information', 'UserController@profileEdit')->name('profileEdit');

    // オーディオ作成
    Route::post('/audio/create', 'AudioController@store')->name('audio.store');
    // ログインユーザーの出品オーディオ一覧
    Route::get('/exhibited_audios', 'AudioController@exhibitedAudios')->name('exhibited_audios');
    // ログインユーザーの特定のオーディオ取得
    Route::get('/exhibited_audio/{id}/show', 'AudioController@exhibitedAudioShow')->name('exhibited_show');
    // ログインユーザーの特定のオーディオアップデート
    Route::post('/exhibited_audio/{id}/update', 'AudioController@exhibitedAudioUpdate')->name('exhibited_update');
    // ログインユーザーの特定のオーディオ削除
    Route::post('/exhibited_audio/{id}/delete', 'AudioController@exhibitedAudioDelete')->name('exhibited_delete');

    // 振り込み口座情報作成
    Route::post('/transferAccount/store', 'TransferAccountController@store')->name('transferAccount.store');
    // 振り込み口座情報アップデート
    Route::post('/transferAccount/{id}/update', 'TransferAccountController@update')->name('transferAccount.update');
    // 振り込み口座情報取得
    Route::get('/transferAccount/show', 'TransferAccountController@show')->name('transferAccount.show');

});
