<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// リクエスト
use App\Http\Requests\AudioRequest;

// モデル
use App\User;
use App\Audio;

class AudioController extends Controller
{

    // オーディオ作成
    public function store(AudioRequest $request) {

        DB::beginTransaction();

        try {
            $user = Auth::user();

            // オーディオファイル以外のカラム
            $audio = new Audio;
            $audio->user_id = $user->id;
            $audio->sound_id = $request->sound_id;
            $audio->title = $request->title;
            $audio->price = $request->price;

            // 以下オーディオファイルの保存
            $audioFile = $request->audio_file;
            // S3にアップロード
            $path = Storage::disk('s3')->put('/audios', $audioFile, 'public');
            // カラムにフルパスを代入
            $audio->audio_file = Storage::disk('s3')->url($path);

             // イメージ(understanding)、用途(use)、使用機材(instrument)関連
             




            $audio->save();

            DB::commit();


            return response()->json([
                'message' => '成功'
            ], 200);

        }
        catch (\Exception $e) {
            // データベース巻き戻し
            DB::rollback();

            // DBに合わせるため、s3ないの画像削除
            Storage::disk('s3')->delete($path);

            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }

    }

    // ログインユーザーのオーディオ一覧
    public function exhibitedAudios() {

        try {
            $audios = Audio::select('*')
            ->where('user_id', Auth::id())
            ->get();

            return response()->json([
                'message' => '成功',
                'audios' => $audios
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }


}
