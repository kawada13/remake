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

    // データベーステスト
    public function testStore()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // 振り込み口座作成

        $params = [
            'bank_name' => 'bank_name',
            'bank_code' => 2,
            'branch_name' => 'branch_name',
            'branch_number' => 211,
            'deposit_type' => 'deposit_type',
            'account_number' => 242213,
            'account_holder' => 'account_holder',
        ];

        $response = $this->actingAs($user)
                         ->json('POST', route('transferAccount.store'), $params);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);

        // 作成された情報がちゃんとデータベースに保存されているのか
        $transferAccount = TransferAccount::first();
        $this->assertEquals($params['bank_name'], $transferAccount->bank_name);

    }

    public function testUpdate()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // 振り込み口座作成
        $transferAccount = factory(TransferAccount::class)->create([
            'user_id' => $user->id,
        ]);
        $params = [
            'bank_name' => 'update_bank_name',
            'bank_code' => 2,
            'branch_name' => 'up_datebranch_name',
            'branch_number' => 211,
            'deposit_type' => 'up_date_deposit_type',
            'account_number' => 242213,
            'account_holder' => 'up_date_account_holder',
        ];


        $response = $this->actingAs($user)
                         ->json('POST', route('transferAccount.update', [
                            'id' => $transferAccount->id,
                        ]), $params);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);

    }
    public function testShow()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // 振り込み口座作成
        $transferAccount = factory(TransferAccount::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
                         ->json('GET', route('transferAccount.show', [
                        ]));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
}
