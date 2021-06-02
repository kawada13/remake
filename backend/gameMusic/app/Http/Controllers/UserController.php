<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// リクエスト
use App\Http\Requests\UserInformationRequest;

// モデル
use App\UserInformation;
use App\User;
use App\Audio;

class UserController extends Controller
{
    // ログインユーザーの情報
    public function loginUserInformation()
    {

        try{
            $user = Auth::user();
            $user_information = UserInformation::select('*')
                ->where('user_id', $user->id)
                ->first();

            return response()->json([
                'user' => $user,
                'user_information' => $user_information,
                'message' => '成功'
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }

    }

    // ログインユーザーが自分のプロフィールを編集
    public function profileEdit(UserInformationRequest $request)
    {

        DB::beginTransaction();

        try {
            // インスタンスか
            $user = User::find($request->user_id);
            $userInformation = UserInformation::select('*')
                            ->where('user_id', $request->user_id)
                            ->first();

            // 画像アップロードされてたら以下
            if ($request->profile_image) {

                //送られてきた画像を取得
                $image = $request->profile_image;

                // すでに画像変更したことがある場合、既存のS3に入ってる画像を削除
                if($userInformation->profile_image) {
                    Storage::disk('s3')->delete(parse_url($userInformation->profile_image)['path']);
                }

                // 新しくアップロードされた画像をS3にアップロード
                $path = Storage::disk('s3')->put('/images', $image, 'public');

                // カラムにフルパスを代入
                $userInformation->profile_image = Storage::disk('s3')->url($path);
            }

            // その他カラム
            $user->name = $request->name;
            if($request->introduce) {
                $userInformation->introduce = $request->introduce;
            }
            if($request->instrument) {
                $userInformation->instrument = $request->instrument;
            }

            // データベース保存
            $user->save();
            $userInformation->save();

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

    // ユーザー情報取得（ユーザーの詳細ページのためのデータを取得する）
    public function show($id) {

        try{
            $user = User::with('userInformation')
                            ->where('id', $id)
                            ->first();
            $userAudios = Audio::where('user_id', $user->id)
                                ->latest()
                                ->take(2)
                                ->get();

            return response()->json([
                'user' => $user,
                'userAudios' => $userAudios,
                'authId' => Auth::id(),
                'message' => '成功'
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }

    }
}
