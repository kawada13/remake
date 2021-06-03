<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

// モデル
use App\User;
use App\Audio;
use App\AudioInstrument;
use App\AudioUnderstanding;
use App\AudioUse;
use App\Favorite;

class FavoriteController extends Controller
{
    // ユーザーがオーディオをお気に入りする
    public function store($id)
    {
        try {
            $audio = Audio::find($id);

            // 既にお気に入りしていたらもう一度お気に入りすることを拒否する
            $is_favorite = $audio->favorite_users()
                                    ->where('user_id', Auth::id())
                                    ->exists();
            if($is_favorite) {
                return response()->json([
                    'message' => '既にお気に入り登録してます.',
                ],500);
            }

            $audio->favorite_users()->attach(Auth::id());

            return response()->json([
                'message' => '成功',
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
    // ユーザーがオーディオをお気に入り解除する
    public function delete($id)
    {
        try{
            $audio = Audio::find($id);
            $audio->favorite_users()->detach(Auth::id());
            return response()->json([
                'message' => '成功',
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
    // ログインユーザーがあるオーディオをお気に入り済かどうかtrue or falseで返す(オーディオ詳細ページで使ってるデータ)
    public function isFavorite($id)
    {
        try{
            $audio = Audio::find($id);

            $is_favorite = $audio->favorite_users()
                                    ->where('user_id', Auth::id())
                                    ->exists();
            return response()->json([
                'message' => '成功',
                'is_favorite' => $is_favorite,
            ],200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
    // ログインユーザーのお気に入り作品一覧
    public function lists()
    {
        try{

            $favorite_audios = Audio::with('user')
                                    ->WhereHas('favorite_users', function($q)  {
                                        $q->whereIn('favorites.user_id', [Auth::id()]);
                                    })
                                    ->get();


            return response()->json([
                'message' => '成功',
                'favorite_audios' => $favorite_audios,
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
