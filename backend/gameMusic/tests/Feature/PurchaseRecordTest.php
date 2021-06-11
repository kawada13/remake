<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// モデル
use App\User;
use App\Audio;
use App\UseMaster;
use App\InstrumentMaster;
use App\SoundMaster;
use App\UnderstaindingMaster;
use App\PurchaseRecord;

class PurchaseRecordTest extends TestCase
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
        $eloquent = app(PurchaseRecord::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(PurchaseRecord::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }
    // リレーションテスト
    public function testPurchaseRecordBelongsToUser()
    {
        $userEloquent = app(User::class);
        $AudioEloquent = app(PurchaseRecord::class);

        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);

        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);
        $this->assertNotEmpty($purchase_record->user);
    }
    public function testPurchaseRecordBelongsToAudio()
    {
        $userEloquent = app(User::class);
        $AudioEloquent = app(PurchaseRecord::class);

        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);

        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);
        $this->assertNotEmpty($purchase_record->audio);
    }

    // データベーステスト
    public function testisPurchase()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('isPurchase', [
                            'id' => $audio->id
                         ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function testindex()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('purchases', [
                         ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function testsales()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('sales', [
                         ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function testpayoutAudio()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('audio_payout', [
                            'id' => $audio->id
                         ]));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function testpayout()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('POST', route('payout', [
                            'id' => $audio->id
                         ]));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);


        // しっかりDBにデータが保存されているのかチェック
        $this->assertDatabaseHas('purchase_records', ['status' => 1]);

    }
    public function testallDatas()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('allDatas'));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function testadminPayment()
    {
        // 管理者ユーザー作成

        $user = factory(User::class)->create([
            'scope' => 1,
        ]);

        // サウンドマスターを作成
        $sound = factory(SoundMaster::class)->create();

        // ユーザーに紐づくオーディオを作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        // 購入履歴作成
        $purchase_record = factory(PurchaseRecord::class)->create([
            'user_id' => $user->id,
            'audio_id' => $audio->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('POST', route('adminPayment', [
                            'id' => $purchase_record->id
                         ]));
        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);


        // しっかりDBにデータが保存されているのかチェック
        $this->assertDatabaseHas('purchase_records', ['status' => 2]);

    }

}
