<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// リクエスト
use App\Http\Requests\RecruitmentRequest;

// モデル
use App\User;
use App\Recruitment;

class RecruitmentController extends Controller
{
    // 作成
    public function store(RecruitmentController $request) {

        DB::beginTransaction();

        try {
            $recruitment = new Recruitment;
            $recruitment->user_id = Auth::id();
            $recruitment->title = $request->title;
            $recruitment->budget = $request->budget;
            $recruitment->content = $request->content;
            $recruitment->save();

            DB::commit();
            return response()->json([
                'message' => '成功',
                'recruitment' => $recruitment
            ],200);
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
    // 編集
    public function update(RecruitmentController $request, $id) {


        DB::beginTransaction();

        try {
            $recruitment = Recruitment::find($id);

            // 自身の募集でないと編集できない
            if($recruitment->user_id !== Auth::id()) {
                return response()->json([
                    'message' => '自身の募集ではないので編集できません。',
                ],500);
            }

            if($request->title) {
                $recruitment->title = $request->title;
            }
            if($request->budget) {
                $recruitment->budget = $request->budget;
            }
            if($request->content) {
                $recruitment->content = $request->content;
            }
            $recruitment->save();

            DB::commit();
            return response()->json([
                'message' => '成功',
                'recruitment' => $recruitment
            ],200);
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
    // 削除
    public function delete($id) {

        DB::beginTransaction();

        try {
            $recruitment = Recruitment::find($id);

            // 自身の募集でないと削除できない
            if($recruitment->user_id !== Auth::id()) {
                return response()->json([
                    'message' => '自身の募集ではないので削除できません。',
                ],500);
            }

            $recruitment->delete();

            DB::commit();
            return response()->json([
                'message' => '成功',
            ],200);
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
    // 全データを取得
    public function index() {

        DB::beginTransaction();

        try {
            $recruitments = Recruitment::with('user')
                                    ->get();

            DB::commit();
            return response()->json([
                'message' => '成功',
                'recruitments' => $recruitments,
            ],200);
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
    // ログインユーザーの全データを取得
    public function loginuUserIndex() {

        DB::beginTransaction();

        try {
            $recruitments = Recruitment::with('user')
                                    ->where('user_id', Auth::id())
                                    ->get();

            DB::commit();
            return response()->json([
                'message' => '成功',
                'recruitments' => $recruitments,
            ],200);
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
    // 詳細
    public function show($id) {

        DB::beginTransaction();

        try {
            $recruitment = Recruitment::with('user')
                                    ->where('id', $id)
                                    ->first();

            DB::commit();
            return response()->json([
                'message' => '成功',
                'recruitment' => $recruitment,
            ],200);
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
