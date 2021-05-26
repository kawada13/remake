<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// リクエスト
use App\Http\Requests\TransferAccountRequest;

// モデル
use App\User;
use App\TransferAccount;


class TransferAccountController extends Controller
{
    public function store(TransferAccountRequest $request) {

        // dd($request);

        DB::beginTransaction();

        try {
            $transferAccount = new TransferAccount;
            $transferAccount->user_id = Auth::id();
            $transferAccount->bank_name = $request->bank_name;
            $transferAccount->bank_code = $request->bank_code;
            $transferAccount->branch_name = $request->branch_name;
            $transferAccount->branch_number = $request->branch_number;
            $transferAccount->deposit_type = $request->deposit_type;
            $transferAccount->account_number = $request->account_number;
            $transferAccount->account_holder = $request->account_holder;
            $transferAccount->save();

            DB::commit();
            return response()->json([
                'message' => '成功',
                'transferAccount' => $transferAccount
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


