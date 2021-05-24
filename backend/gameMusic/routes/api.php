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

Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('register');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ユーザー関連
    Route::get('/user_information', 'UserController@loginUserInformation')->name('loginUserInformation');
    Route::post('/user_information', 'UserController@profileEdit')->name('profileEdit');

    // マスターテーブル関連
    Route::get('/sound_type/sound', 'SoundTypeController@sound')->name('type.sound');
    Route::get('/sound_type/understanding', 'SoundTypeController@understanding')->name('type.understanding');

    // オーディオ関連

    // オーディオ作成
    Route::post('/audio/create', 'AudioController@store')->name('audio.store');
    // ログインユーザーの出品オーディオ一覧
    Route::get('/exhibited_audios', 'AudioController@exhibitedAudios')->name('exhibited_audios');

});
