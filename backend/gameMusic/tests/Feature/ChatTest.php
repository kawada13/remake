<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// モデル
use App\User;
use App\UserInformation;
use App\ChatRoomUser;
use App\ChatRoom;
use App\ChatMessage;

class ChatTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // モデルのテスト
    public function testChatRoomFactoryable()
    {
        $eloquent = app(ChatRoom::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(ChatRoom::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }
    public function testChatMessageFactoryable()
    {
        $eloquent = app(ChatMessage::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(ChatMessage::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }
    public function testChatRoomUserFactoryable()
    {
        $eloquent = app(ChatRoomUser::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(ChatRoomUser::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    // リレーションテスト
    public function testChatRoomHasManychatRoomUsers()
    {
        $count = 5;
        $chatroomEloquent = app(ChatRoom::class);
        $chatroomuserEloquent = app(ChatRoomUser::class);
        $user = factory(ChatRoom::class)->create(); // ユーザーを作成
        $chatRoom = factory(ChatRoom::class)->create(); // チャットルームを作成
        $chatRoomUsers = factory(ChatRoomUser::class, $count)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);
        $this->assertEquals($count, count($chatRoom->refresh()->chatRoomUsers));
    }
    public function testChatRoomHasManychatMessages()
    {
        $count = 5;
        $chatroomEloquent = app(ChatRoom::class);
        $chatmessageEloquent = app(ChatMessage::class);
        $user = factory(ChatRoom::class)->create(); // ユーザーを作成
        $chatRoom = factory(ChatRoom::class)->create(); // チャットルームを作成
        $chatMessagess = factory(ChatMessage::class, $count)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);
        $this->assertEquals($count, count($chatRoom->refresh()->chatMessages));
    }
    public function testChatMessageBelongsTochatRoom()
    {
        $chatroomEloquent = app(ChatRoom::class);
        $chatmessageEloquent = app(ChatMessage::class);

        // チャットルームを作成
        $chatRoom = factory(ChatRoom::class)->create();

        // ユーザーを作成
        $user = factory(User::class)->create();

        // チャットメッセージを作成
        $chatMessage = factory(ChatMessage::class)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);

        $this->assertNotEmpty($chatMessage->chatRoom);
    }
    public function testChatMessageBelongsToUser()
    {
        $userEloquent = app(User::class);
        $chatmessageEloquent = app(ChatMessage::class);

        // チャットルームを作成
        $chatRoom = factory(ChatRoom::class)->create();

        // ユーザーを作成
        $user = factory(User::class)->create();

        // チャットメッセージを作成
        $chatMessage = factory(ChatMessage::class)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);

        $this->assertNotEmpty($chatMessage->user);
    }
    public function testChatRoomUserBelongsTochatRoom()
    {
        $chatroomEloquent = app(ChatRoom::class);
        $chatroomuserEloquent = app(ChatRoomUser::class);

        // チャットルームを作成
        $chatRoom = factory(ChatRoom::class)->create();

        // ユーザーを作成
        $user = factory(User::class)->create();

        // チャットルームユーザーを作成
        $chatRoomUser = factory(ChatRoomUser::class)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);

        $this->assertNotEmpty($chatRoomUser->chatRoom);
    }
    public function testChatRoomUserBelongsToUser()
    {
        $userEloquent = app(User::class);
        $chatmessageEloquent = app(ChatRoomUser::class);

        // チャットルームを作成
        $chatRoom = factory(ChatRoom::class)->create();

        // ユーザーを作成
        $user = factory(User::class)->create();

        // チャットルームユーザーを作成
        $chatRoomUser = factory(ChatRoomUser::class)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);

        $this->assertNotEmpty($chatRoomUser->user);
     }



    //  モデルのテスト

    public function test_createChat()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $params = [
            'message' => 'こんにちは',
        ];

        $response = $this->actingAs($user)
                         ->json('POST', route('createChat', [
                            'id' => $user->id,
                        ]), $params);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

    public function test_chatRooms()
    {
        // チャットルームを作成
        $chatRoom = factory(ChatRoom::class)->create();

        // ユーザーを作成
        $user = factory(User::class)->create();

        // チャットルームユーザーを作成
        $chatRoomUser = factory(ChatRoomUser::class)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);

        $response = $this->actingAs($user)
                         ->json('GET', route('chatRooms'));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
    public function test_chatMessages()
    {
        // チャットルームを作成
        $chatRoom = factory(ChatRoom::class)->create();

        // ユーザーを作成
        $user = factory(User::class)->create();

        // チャットメッセージを作成
        $chatMessage = factory(ChatMessage::class)->create([
            'user_id' => $user->id,
            'chat_room_id' => $chatRoom->id,
        ]);

        $response = $this->actingAs($user)
            ->json('GET', route('chatMessages', [
                'id' => $user->id,
            ]));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }

}
