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

class FavoriteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    //  お気に入り登録登録
    public function test_Store()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);

        $response = $this->actingAs($user)
            ->json('POST', route('favorite', [
                'id' => $audio->id,
            ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }

    //  お気に入り登録解除
    public function test_delete()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);

        // お気に入り登録
        $audio->favorite_users()->attach($user->id);

        $response = $this->actingAs($user)
            ->json('POST', route('unfavorite', [
                'id' => $audio->id,
            ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
    //  既にお気に入りすみかどうかのチェック
    public function test_isFavorite()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);

        // お気に入り登録
        $audio->favorite_users()->attach($user->id);

        $response = $this->actingAs($user)
            ->json('POST', route('isfavorite', [
                'id' => $audio->id,
            ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
    //  お気に入り一覧取得
    public function test_lists()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);

        // お気に入り登録
        $audio->favorite_users()->attach($user->id);

        $response = $this->actingAs($user)
            ->json('GET', route('favoriteLists'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
}
