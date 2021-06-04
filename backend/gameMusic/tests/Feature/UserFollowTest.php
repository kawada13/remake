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

class UserFollowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;


    //  フォロー
    public function test_Store()
    {
        // ログインユーザー作成
        $user = factory(User::class)->create();

        // フォロー対象ユーザー作成
        $follower = factory(User::class)->create();


        $response = $this->actingAs($user)
            ->json('POST', route('follow', [
                'id' => $follower->id,
            ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }

    //  フォロー解除
    public function test_delete()
    {
        // ログインユーザー作成
        $user = factory(User::class)->create();

        // フォロー対象ユーザー作成
        $follower = factory(User::class)->create();

        // フォロー
        $follower->followers()->attach($user->id);

        $response = $this->actingAs($user)
            ->json('POST', route('unfollow', [
                'id' => $follower->id,
            ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
    //  既にフォローすみかどうかのチェック
    public function test_isFollow()
    {
        // ログインユーザー作成
        $user = factory(User::class)->create();

        // フォロー対象ユーザー作成
        $follower = factory(User::class)->create();

        // フォロー
        $follower->followers()->attach($user->id);

        $response = $this->actingAs($user)
            ->json('POST', route('isfollow', [
                'id' => $follower->id,
            ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
    //  フォロー一覧取得
    public function test_lists()
    {
        // ログインユーザー作成
        $user = factory(User::class)->create();

        // フォロー対象ユーザー作成
        $follower = factory(User::class)->create();

        // フォロー
        $follower->followers()->attach($user->id);

        $response = $this->actingAs($user)
            ->json('GET', route('followLists'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);
    }
}
