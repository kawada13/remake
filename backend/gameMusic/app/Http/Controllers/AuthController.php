<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// リクエスト
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

// モデル
use App\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'user' => Auth::user(),
                'message' => 'ログイン成功'
            ], 200);
        }

        return response()->json([
            'message' => 'ログイン失敗'
        ], 500);

    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            DB::commit();

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'user' => Auth::user(),
                    'message' => '登録アンドログイン成功'
                ], 200);
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => '失敗'
            ],500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'ログアウトしました。'], 200);
    }
}
