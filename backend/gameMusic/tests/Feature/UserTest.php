<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// モデル
use App\User;
use App\UserInformation;
use App\Audio;
use App\SoundMaster;

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
        $this->assertNotEmpty($user->userInformation);
    }

    public function testUserHasManyAudios()
    {
        $count = 5;
        $userEloquent = app(User::class);
        $audioEloquent = app(Audio::class);
        $user = factory(User::class)->create(); // ユーザーを作成
        $sound = factory(SoundMaster::class)->create(); // サウンドマスターを作成
        $audios = factory(Audio::class, $count)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]); // ユーザーに紐づくオーディオを作成
        $this->assertEquals($count, count($user->refresh()->audios));
    }
    public function test_show()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        $response = $this->json('GET', route('user.show', [
                            'id' => $user->id
                         ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }
}
