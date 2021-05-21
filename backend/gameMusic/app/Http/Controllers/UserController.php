<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// リクエスト
use App\Http\Requests\UserInformationRequest;

// モデル
use App\UserInformation;
use App\User;

class UserController extends Controller
{
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

    public function profileEdit(UserInformationRequest $request)
    {

        try{

        }
        catch (\Exception $e) {

        }

    }
}  
 