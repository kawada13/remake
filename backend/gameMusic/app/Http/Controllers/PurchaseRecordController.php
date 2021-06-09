<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// リクエスト
use App\Http\Requests\PurchaseRecordRequest;

// モデル
use App\User;
use App\Audio;
use App\AudioInstrument;
use App\AudioUnderstanding;
use App\AudioUse;
use App\PurchaseRecord;

class PurchaseRecordController extends Controller
{

    // 購入データを保存
    public function purchase(PurchaseRecordRequest $request, $id)
    {


        try {

            $audio = Audio::find($id);

            // 自身の作品だったらアウト
            if($audio->user_id == Auth::id()) {
                return response()->json([
                    'message' => '自身の作品のため購入できません。',
                ], 500);
            }

            // 重複購入アウト
            $is_purchased = $audio->purchase_users()
                                    ->where('user_id', Auth::id())
                                    ->exists();
            if($is_purchased) {
                return response()->json([
                    'message' => '購入済です.',
                ],500);
            }

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = \Stripe\Customer::create([
                'source' => $request->token_id, // クレジットカードトークン
                'email'  => $request->email, // メールアドレス
                'name'   => $request->name,  // 顧客の名前
            ]);

            $PurchaseRecord = new PurchaseRecord;
            $PurchaseRecord->user_id = Auth::id();
            $PurchaseRecord->audio_id = $id;
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

    // あるオーディオを購入済かどうかチェック
    public function isPurchase($id) {

        try{
            $audio = Audio::find($id);

            $is_purchase = $audio->purchase_users()
                                    ->where('user_id', Auth::id())
                                    ->exists();
            return response()->json([
                'message' => '成功',
                'is_purchase' => $is_purchase,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }

    // ログインユーザーの購入オーディオ一覧
    public function index() {

        try{
            $purchases = Audio::with(['user', 'purchaseRecords'])
                                    ->withTrashed() //クリエイターが削除したものも含む
                                    ->WhereHas('purchase_users', function($q)  {
                                        $q->whereIn('purchase_records.user_id', [Auth::id()]);
                                    })
                                    ->get();

            return response()->json([
                'message' => '成功',
                'purchases' => $purchases,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }

    // ログインユーザーが出品した商品のうち、購入されたデータ一覧を取得
    public function sales() {

        try{
            $sales_records = PurchaseRecord::with(['user', 'audio'])
                                    ->WhereHas('audio', function($q)  {
                                        $q->whereIn('user_id', [Auth::id()]);
                                    })
                                    ->get();

            return response()->json([
                'message' => '成功',
                'sales_records' => $sales_records,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
    // 全てのデータ
    public function allDatas() {

        try{
            $records = PurchaseRecord::with(['user', 'audio'])
                                    ->get();

            return response()->json([
                'message' => '成功',
                'records' => $records,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }

    // 振込申請ページ用で使うオーディオデータ取得
    public function payoutAudio($id) {

        try{
            $audio = Audio::find($id);

            // ログインユーザー自身のオーディオじゃなければ、振込申請が行われては困る(url直打ち対策)⇨これに引っ掛かればリダイレクトreplace
            if(Auth::id() !== $audio->user_id){
                return response()->json([
                    'message' => '不正なアクセスです。',
                ],500);
            }

            return response()->json([
                'message' => '成功',
                'audio' => $audio,
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
    
    // 振込申請
    public function payout($id) {

        DB::beginTransaction();

        try{
            $today = date("Y-m-d H:i:s");


            $purchase_record = PurchaseRecord::where('audio_id', $id)
                                               ->first();
            $purchase_record->status = 1;
            $purchase_record->withdraw_at = $today;
            $purchase_record->save();

            DB::commit();

            return response()->json([
                'message' => '成功',
            ],200);

        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }


    }

}
