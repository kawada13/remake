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
use App\AudioInstrument;
use App\AudioUnderstanding;
use App\AudioUse;

class AudioController extends Controller
{

    // オーディオ作成
    public function store(AudioRequest $request) {

        DB::beginTransaction();

        try {
            // オーディオファイル以外のカラム
            $audio = new Audio;
            $audio->user_id = Auth::id();
            $audio->sound_id = $request->sound_id;
            $audio->title = $request->title;
            $audio->price = $request->price;

            // 以下オーディオファイルの保存
            $audioFile = $request->audio_file;
            // S3にアップロード
            $path = Storage::disk('s3')->put('/audios', $audioFile, 'public');
            // カラムにフルパスを代入
            $audio->audio_file = Storage::disk('s3')->url($path);

            $audio->save();

             // イメージ(understanding)、用途(use)、使用機材(instrument)関連

             if($request->understanding) {
                //  送られてきたデータを配列化
                $understandings = explode(",", $request->understanding);

                // 中間テーブルに値を代入
                foreach($understandings as $understanding){
                    $audio_understanding = new AudioUnderstanding;
                    $audio_understanding->audio_id = $audio->id;
                    $audio_understanding->understanding_id = $understanding;
                    $audio_understanding->save();
                 }
             }

             if($request->use) {
                 //  送られてきたデータを配列化
                $uses = explode(",", $request->use);

                // 中間テーブルに値を代入
                foreach($uses as $use){
                    $audio_use = new AudioUse;
                    $audio_use->audio_id = $audio->id;
                    $audio_use->use_id = $use;
                    $audio_use->save();
                 }
             }
             if($request->instrument) {
                 //  送られてきたデータを配列化
                $instruments = explode(",", $request->instrument);

                // 中間テーブルに値を代入
                foreach($instruments as $instrument){
                    $audio_instrument = new AudioInstrument;
                    $audio_instrument->audio_id = $audio->id;
                    $audio_instrument->instrument_id = $instrument;
                    $audio_instrument->save();
                 }

             }

            //  コミット
            DB::commit();

            return response()->json([
                'message' => '成功'
            ], 200);

        }
        catch (\Exception $e) {
            // データベース巻き戻し
            DB::rollback();

            // DBに合わせるため、s3内のオーディオ削除
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

    // ログインユーザーの特定のオーディオ取得
    public function exhibitedAudioShow($id) {

        try {
            $audio = Audio::find($id);
            $audioInstrument = $audio->audioInstruments;
            $audioUnderstanding = $audio->audioUnderstandings;
            $audioUse = $audio->audioUses;

            // ログインユーザーのオーディオ編集ページを他のユーザーがアクセスしようとしたら拒否
            if (Auth::id() === $audio->user_id) {
                return response()->json([
                    'message' => '成功',
                    'audio' => $audio,
                    'audioInstrument' => $audioInstrument,
                    'audioUse' => $audioUse,
                    'audioUnderstanding' => $audioUnderstanding,
                    'isloginUserAudio' => true
                ], 200);
            }

            return response()->json([
                'isloginUserAudio' => false
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }

    // 特定のオーディオ取得
    public function audioShow($id) {

        try {
            $audio = Audio::find($id);
            $audioInstrument = $audio->audioInstruments;
            $audioUnderstanding = $audio->audioUnderstandings;
            $audioUse = $audio->audioUses;

            return response()->json([
                'message' => '成功',
                'audio' => $audio,
                'audioInstrument' => $audioInstrument,
                'audioUse' => $audioUse,
                'audioUnderstanding' => $audioUnderstanding,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }

    // ログインユーザーの特定のオーディオ編集
    public function exhibitedAudioUpdate(AudioRequest $request, $id) {

        DB::beginTransaction();

        try {
            $audio = Audio::find($id);

            // まずはオーディオテーブルを更新
            $audio->sound_id = $request->sound_id;
            $audio->title = $request->title;
            $audio->price = $request->price;

            // 以下オーディオファイルの保存
            $audioFile = $request->audio_file;
            // 既存のS3に入ってるオーディオを削除
            Storage::disk('s3')->delete(parse_url($audio->audio_file)['path']);
            // S3にアップロード
            $path = Storage::disk('s3')->put('/audios', $audioFile, 'public');
            // カラムにフルパスを代入
            $audio->audio_file = Storage::disk('s3')->url($path);


            // ログインユーザーのオーディオ編集ページを他のユーザーがアクセスしようとしたら拒否
            if (Auth::id() === $audio->user_id) {

                // イメージ(understanding)、用途(use)、使用機材(instrument)関連を更新
                // 一旦削除
                AudioInstrument::where('audio_id',$audio->id)->delete();
                AudioUnderstanding::where('audio_id',$audio->id)->delete();
                AudioUse::where('audio_id',$audio->id)->delete();

                // 保存

                // (understanding)
                //  送られてきたデータを配列化
                $understandings = explode(",", $request->understanding);

                // 中間テーブルに値を代入
                foreach($understandings as $understanding){
                    $audio_understanding = new AudioUnderstanding;
                    $audio_understanding->audio_id = $audio->id;
                    $audio_understanding->understanding_id = $understanding;
                    $audio_understanding->save();
                }

                // (use)
                //  送られてきたデータを配列化
                $uses = explode(",", $request->use);

                // 中間テーブルに値を代入
                foreach($uses as $use){
                    $audio_use = new AudioUse;
                    $audio_use->audio_id = $audio->id;
                    $audio_use->use_id = $use;
                    $audio_use->save();
                }

                // (instruments)
                //  送られてきたデータを配列化
                $instruments = explode(",", $request->instrument);

                // 中間テーブルに値を代入
                foreach($instruments as $instrument){
                    $audio_instrument = new AudioInstrument;
                    $audio_instrument->audio_id = $audio->id;
                    $audio_instrument->instrument_id = $instrument;
                    $audio_instrument->save();
                }
                // セーブ
                $audio->save();
                //  コミット
                DB::commit();

                return response()->json([
                    'message' => '成功',
                    'isloginUserAudio' => true
                ], 200);
            }

            // もしログインユーザーじゃなければ、DBに合わせるため、s3内のオーディオ削除
            Storage::disk('s3')->delete($path);

            // データベース巻き戻し
            DB::rollback();

            return response()->json([
                'isloginUserAudio' => false
            ], 200);
        }
        catch (\Exception $e) {
            // データベース巻き戻し
            DB::rollback();

            // DBに合わせるため、s3内のオーディオ削除
            Storage::disk('s3')->delete($path);

            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }

    // ログインユーザーの特定のオーディオ削除
    public function exhibitedAudioDelete($id)
    {
        DB::beginTransaction();

        try {
            $audio = Audio::find($id);
            // ログインユーザーのオーディオ編集ページを他のユーザーがアクセスしようとしたら拒否
           if (Auth::id() === $audio->user_id) {

               // 関連するsoundTypeの中間テーブルのデータ削除
               AudioInstrument::where('audio_id',$audio->id)->delete();
               AudioUnderstanding::where('audio_id',$audio->id)->delete();
               AudioUse::where('audio_id',$audio->id)->delete();

               // ソフトデリート
               $audio->delete();

               // s3内のオーディオ削除
               Storage::disk('s3')->delete(parse_url($audio->audio_file)['path']);

               DB::commit();

               return response()->json([
                'isloginUserAudio' => true
              ], 200);
           }

           return response()->json([
            'isloginUserAudio' => false
          ], 200);
        }
        catch (\Exception $e) {

            // データベース巻き戻し
            DB::rollback();

            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }


}
