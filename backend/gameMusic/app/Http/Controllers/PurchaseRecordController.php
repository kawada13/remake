<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// モデル
use App\User;
use App\Audio;
use App\AudioInstrument;
use App\AudioUnderstanding;
use App\AudioUse;
use App\PurchaseRecord;

class PurchaseRecordController extends Controller
{
    public function purchase(Request $request)
    {

        try {

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = \Stripe\Customer::create([
                'source' => $request->token_id, // クレジットカードトークン
                'email'  => $request->mail, // メールアドレス
                'name'   => $request->name,  // 顧客の名前
            ]);

            $PurchaseRecord = new PurchaseRecord;
            $PurchaseRecord->user_id = Auth::id();
            $PurchaseRecord->audio_id = 1;
            $PurchaseRecord->stripe_id = $customer->id;
            $PurchaseRecord->price = $request->price;
            $PurchaseRecord->save();


            $charge = \Stripe\Charge::create([
                'amount'   => $request->price,     // 金額
                'currency' => 'jpy',       // 単位
                'customer' => $customer->id, // 顧客ID
            ]);

            $customer = \Stripe\Customer::retrieve($PurchaseRecord->stripe_id);

            return response()->json([
                'message' => '成功',
                'customer' => $customer
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }

    }
}
