<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// モデル
use App\User;
use App\UserInformation;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // モデルのテスト
    public function testFactoryable()
    {
        $eloquent = app(User::class);
        // 最初は空
        $this->assertEmpty($eloquent->get());
        // ユーザーをファクトリーにてクリエイト
        $entity = factory(User::class)->create();
        // クリエイトされたユーザーが存在するのかチェック
        $this->assertNotEmpty($eloquent->get());
    }

    // リレーション
    public function testUserHasOneUserInformation()
    {
        $userEloquent = app(User::class);
        $userInformationEloquent = app(UserInformation::class);

        // ユーザー作成
        $user = factory(User::class)->create();

        // ユーザーインフォ作成
        $userInformation = factory(UserInformation::class)->create([
            'user_id' => $user->id,
        ]);
        $this->assertNotEmpty($user->user_information);
    }
}
