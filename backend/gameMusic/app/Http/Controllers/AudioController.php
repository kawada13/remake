<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
// use FFMpeg;

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
            // S3にアップロード(フルバージョのほう)
            $path = Storage::disk('s3')->put('/audios/product', $audioFile, 'public');

            // カラムにフルパスを代入(フルバージョンの方)
            $audio->audio_file = Storage::disk('s3')->url($path);


            // これから編集したオーディオを一時的にstorageに保存するため、もし既に存在していたら一旦削除
            if(Storage::exists('public/output_file.mp3')) {
                Storage::delete('public/output_file.mp3');
            }

            // ffmpegにてオーディオを編集アンド実行
            $command = "/usr/local/bin/ffmpeg -i $audioFile -t 5 /work/gameMusic/storage/app/public/output_file.mp3" . " 2>&1";
            exec($command, $output, $return_var);

            // 編集したオーディオファイルをstorageから取得
            $sample_audio_file = Storage::get('public/output_file.mp3');

            // 編集したオーディオファイルをs3に保存するための名前を生成
            $sample_audio_file_name = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');

            // 編集したオーディオファイルをs3にアップロード(さっき作った名前を利用して)
            Storage::disk('s3')->put('/audios/sample/'. $sample_audio_file_name, $sample_audio_file, 'public');

            // 編集したオーディオのs3のフルパスを取得
            $sample_path = Storage::disk('s3')->url('audios/sample/'. $sample_audio_file_name);

            // カラムにフルパスを代入(編集した方)
            $audio->sample_audio_file = $sample_path;


            $audio->save();

             // イメージ(understanding)、用途(use)、使用機材(instrument)関連

             if($request->understanding) {
                //  送られてきたデータを配列化
                $understandings = explode(",", $request->understanding);

                // 中間テーブルに値を代入
                foreach($understandings as $understanding){
                    $audio->understandings()->attach($understanding);
                 }
             }

             if($request->use) {
                 //  送られてきたデータを配列化
                $uses = explode(",", $request->use);

                // 中間テーブルに値を代入
                foreach($uses as $use){
                    $audio->uses()->attach($use);
                 }
             }
             if($request->instrument) {
                 //  送られてきたデータを配列化
                $instruments = explode(",", $request->instrument);

                // 中間テーブルに値を代入
                foreach($instruments as $instrument){
                    $audio->instruments()->attach($instrument);
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
            Storage::disk('s3')->delete('audios/sample/'. $sample_audio_file_name);

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
            $audioInstrument = $audio->instruments;
            $audioUnderstanding = $audio->understandings;
            $audioUse = $audio->uses;

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
            $audio = Audio::with('user')
                            ->where('id', $id)
                            ->first();
            $audioInstrument = $audio->instruments;
            $audioUnderstanding = $audio->understandings;
            $audioUse = $audio->uses;
            // 以下は詳細情報で表示させるために取得
            $userInformation = $audio->user->userInformation;
            $sound = $audio->sound;

            return response()->json([
                'message' => '成功',
                'audio' => $audio,
                'userInformation' => $userInformation,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
    // 検索オーディオ取得
    public function audioSearchIndex(Request $request) {

        try {
            // リレーション先検索をするため、各IDを配列化
            $soundId = [$request->sound];
            $understandingId = [$request->understanding];
            $useId = [$request->use];
            $instrumentId = [$request->instrument];

            // A のみ⇨もし「キーワード」のみ入力されていたら
            if($request->keyword && !$request->sound && !$request->understanding && !$request->use && !$request->instrument) {
                $audios = Audio::with('user')
                                 ->where('title', 'like', "%$request->keyword%")->get();
            }

            // A and (B or C or D or E)⇨もし「キーワード」かつ「サウンドタイプ」が入力されていたら
            if(($request->keyword) && ($request->sound || $request->understanding || $request->use || $request->instrument)) {
                $audios = Audio::with('user')
                                ->where('title', 'like', "%$request->keyword%")
                                ->where(function($query) use($soundId, $understandingId, $useId, $instrumentId){
                                    $query->WhereHas('sound', function($q) use($soundId)  {
                                        $q->whereIn('id', $soundId);
                                    })
                                    ->orWhereHas('understandings', function($q) use($understandingId)  {
                                        $q->whereIn('audio_understanding.understanding_id', $understandingId);
                                    })
                                    ->orWhereHas('uses', function($q) use($useId)  {
                                        $q->whereIn('audio_use.use_id', $useId);
                                    })
                                    ->orWhereHas('instruments', function($q) use($instrumentId)  {
                                        $q->whereIn('audio_instrument.instrument_id', $instrumentId);
                                    });
                                })
                                ->get();
            }

            // (B or C or D or E) のみ⇨もし「サウンドタイプ」のみ入力されていたら
            if((!$request->keyword) && ($request->sound || $request->understanding || $request->use || $request->instrument)) {
                $audios = Audio::with('user')
                                 ->WhereHas('sound', function($q) use($soundId)  {
                                        $q->whereIn('id', $soundId);
                                    })
                                    ->orWhereHas('understandings', function($q) use($understandingId)  {
                                        $q->whereIn('audio_understanding.understanding_id', $understandingId);
                                    })
                                    ->orWhereHas('uses', function($q) use($useId)  {
                                        $q->whereIn('audio_use.use_id', $useId);
                                    })
                                    ->orWhereHas('instruments', function($q) use($instrumentId)  {
                                        $q->whereIn('audio_instrument.instrument_id', $instrumentId);
                                    })
                                    ->get();
            }

            // 検索欄に何も入力がなかったら
            if(!$request->keyword && !$request->sound && !$request->understanding && !$request->use && !$request->instrument) {
                $audios = Audio::with('user')->get();
            }


            return response()->json([
                'message' => '検索成功',
                'audios' => $audios,
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
            // 既存のS3に入ってるオーディオ(フルバージョン)を削除
            Storage::disk('s3')->delete(parse_url($audio->audio_file)['path']);
            // S3にアップロード（フルバージョン）
            $path = Storage::disk('s3')->put('/audios/product', $audioFile, 'public');
            // カラムにフルパスを代入(フルバージョン)
            $audio->audio_file = Storage::disk('s3')->url($path);



            // これから編集したオーディオを一時的にstorageに保存するため、もし既に存在していたら一旦削除
            if(Storage::exists('public/output_file.mp3')) {
                Storage::delete('public/output_file.mp3');
            }

            // ffmpegにてオーディオを編集アンド実行
            $command = "/usr/local/bin/ffmpeg -i $audioFile -t 5 /work/gameMusic/storage/app/public/output_file.mp3" . " 2>&1";
            exec($command, $output, $return_var);

            // 編集したオーディオファイルをstorageから取得
            $sample_audio_file = Storage::get('public/output_file.mp3');

            // 既存のS3に入ってるオーディオ(フルバージョン)を削除
            Storage::disk('s3')->delete(parse_url($audio->sample_audio_file)['path']);

            // 編集したオーディオファイルをs3に保存するための名前を生成
            $sample_audio_file_name = str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz');

            // 編集したオーディオファイルをs3にアップロード(さっき作った名前を利用して)
            Storage::disk('s3')->put('/audios/sample/'. $sample_audio_file_name, $sample_audio_file, 'public');

            // 編集したオーディオのs3のフルパスを取得
            $sample_path = Storage::disk('s3')->url('audios/sample/'. $sample_audio_file_name);

            // カラムにフルパスを代入(編集した方)
            $audio->sample_audio_file = $sample_path;


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
                if($request->understanding) {
                    $understandings = explode(",", $request->understanding);

                    // テーブルに値を代入
                    foreach($understandings as $understanding){
                        $audio->understandings()->attach($understanding);
                    }
                }

                // (use)
                //  送られてきたデータを配列化
                if($request->use) {
                    $uses = explode(",", $request->use);

                    // テーブルに値を代入
                    foreach($uses as $use){
                        $audio->uses()->attach($use);
                    }
                }

                // (instruments)
                //  送られてきたデータを配列化
                if($request->instrument) {
                    $instruments = explode(",", $request->instrument);

                    // 中間テーブルに値を代入
                    foreach($instruments as $instrument){
                        $audio->instruments()->attach($instrument);
                    }
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
            Storage::disk('s3')->delete('audios/sample/'. $sample_audio_file_name);

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

    // 過去に作られた古い順6件のオーディオ情報(トップのオーディオ一覧のところに載せるやつ)
    public function oldAudios() {

        try {
            $audios = Audio::with('user')
                            ->oldest()
                            ->take(6)
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
    // 新着順3件のオーディオ情報(新着オーディオのところに載せるやつ)
    public function newAudios() {

        try {
            $audios = Audio::with('user')
                            ->latest()
                            ->take(3)
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

    // 特定のユーザーのオーディオ一覧(ユーザー詳細から「もっとみる」を押して進んだページで使うデータ)
    public function userAudios($id) {

        try {
            $audios = Audio::with('user')
                            ->where('user_id', $id)
                            ->get();

            return response()->json([
                'message' => '成功',
                'audios' => $audios,
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
