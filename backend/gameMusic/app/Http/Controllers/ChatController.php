<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


// モデル
use App\ChatRoom;
use App\ChatRoomUser;
use App\ChatMessage;
use App\User;

// リクエスト
use App\Http\Requests\ChatRequest;


// イベント
use App\Events\ChatPusher;

class ChatController extends Controller
{

     // メッセージ作成
    public function createChat(ChatRequest $request, $id){

        // 自分の持っているチャットルームを取得
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
        ->pluck('chat_room_id');

        // 自分の持っているチャットルームからチャット相手のいるルームを探す(るーむid)
        $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
            ->where('user_id', $id)
            ->pluck('chat_room_id');


        // なければ作成する
        if ($chat_room_id->isEmpty()){

            ChatRoom::create(); //チャットルーム作成

            $latest_chat_room = ChatRoom::orderBy('created_at', 'desc')->first(); //最新チャットルームを取得

            $chat_room_id = $latest_chat_room->id;

            // 自身を登録
            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => Auth::id()]);

            // 相手も登録
            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => $id]);
        }

        // チャットルーム取得時はオブジェクト型なので数値に変換
        if(is_object($chat_room_id)){
            $chat_room_id = $chat_room_id->first();
        }


        // チャット内容を作成
        $chat = new ChatMessage();
        $chat->chat_room_id = $chat_room_id;
        $chat->user_id = Auth::id();
        $chat->message = $request->message;
        $chat->save();


        return response()->json([
            'message' => '成功',
        ], 200);

    }
     // ログインユーザーのチャットルーム一覧
    public function chatRooms(){

        try {

            $chat_rooms = ChatRoomUser::with('user')
                                        ->where('user_id', Auth::id())
                                        ->get();

            return response()->json([
                'message' => '成功',
                'chat_rooms' => $chat_rooms
            ], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }

    }

     // ある相手とのチャット履歴取得
    public function chatMessages($id){

        try {

            // 自分の持っているチャットルームを取得
            $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
            ->pluck('chat_room_id');

            // 自分の持っているチャットルームからチャット相手のいるルームを探す(るーむid)
            $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
                ->where('user_id', $id)
                ->pluck('chat_room_id');

            $chat_messages = [];


            // なければからの配列を返す
            if ($chat_room_id->isEmpty()){
                return response()->json([
                    'message' => '成功',
                    'chat_messages' => $chat_messages,
                ], 200);
            } else {
                $chat_messages = ChatMessage::with('user')
                                            ->where('chat_room_id', $$chat_room_id)
                                            ->get();

                return response()->json([
                    'message' => '成功',
                    'chat_messages' => $chat_messages,
                ], 200);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }

    }
}
