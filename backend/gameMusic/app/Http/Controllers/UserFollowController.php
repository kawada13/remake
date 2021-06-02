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

class UserFollowController extends Controller
{
    // ログインユーザーがあるユーザーをフォローする
    public function store($id)
    {
        try {
            $user = User::find($id);

            // 既にフォローしていたらもう一度フォローすることを拒否する
            $is_follow = $user->followers()
                                    ->where('follow_id', Auth::id())
                                    ->exists();
            if($is_follow) {
                return response()->json([
                    'message' => '既にフォローしてます.',
                ],500);
            }

            // フォローする相手が自分だったらフォローすることを拒否
            if($user->id == Auth::id()) {
                return response()->json([
                    'message' => 'フォロー対象が自身なので拒否',
                ],500);
            }

            $user->followers()->attach(Auth::id());

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
    // ログインユーザーがフォローを解除
    public function delete($id)
    {
        try{
            $user = User::find($id);
            $user->followers()->detach(Auth::id());
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
    // ログインユーザーがあるユーザーをフォロー済かどうかtrue or falseで返す
    public function isFollow($id)
    {
        try{
            $user = User::find($id);

            $is_follow = $user->followers()
                                    ->where('follow_id', Auth::id())
                                    ->exists();
            return response()->json([
                'message' => '成功',
                'is_follow' => $is_follow,
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
