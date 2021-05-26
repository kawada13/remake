<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// モデル
use App\User;
use App\TransferAccount;

class TransferAccountTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    //  モデルのテスト
    public function testFactoryable()
    {
        $eloquent = app(TransferAccount::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(TransferAccount::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    // リレーションテスト
    public function testAudioBelongsToUser()
    {
        $userEloquent = app(User::class);
        $AudioEloquent = app(TransferAccount::class);

        // ユーザー作成
        $user = factory(User::class)->create();

        // 振り込み口座作成
        $transferAccount = factory(TransferAccount::class)->create([
            'user_id' => $user->id,
        ]);
        $this->assertNotEmpty($transferAccount->user);
    }
}
