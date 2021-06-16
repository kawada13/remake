<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


// モデル
use App\User;
use App\UserInformation;
use App\Recruitment;


class RecruitmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    // モデルのテスト
    public function testRecruitmentFactoryable()
    {
        $eloquent = app(Recruitment::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(Recruitment::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    // リレーションテスト
    public function testRecruitmentBelongsToUser()
    {
        $userEloquent = app(User::class);
        $RecruitmentEloquent = app(Recruitment::class);

        // ユーザーを作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertNotEmpty($Recruitment->user);
    }

    // データベーステスト

    public function test_store()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $params = [
            'title' => 'タイトルです',
            'content' => '募集内容です',
        ];

        $response = $this->actingAs($user)
                         ->json('POST', route('recruitment.store'), $params);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

    public function test_update()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信
        $params = [
            'title' => 'タイトルです',
            'content' => '募集内容です',
        ];

        $response = $this->actingAs($user)
                         ->json('POST', route('recruitment.update', [
                            'id' => $Recruitment->id,
                        ]), $params);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

    public function test_delete()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信

        $response = $this->actingAs($user)
                         ->json('DELETE', route('recruitment.delete', [
                            'id' => $Recruitment->id,
                        ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

        // DBから本当にデータがなくなっているのか確認
        $this->assertDatabaseMissing('recruitments', ['id' => $Recruitment->id]); 
    }
    public function test_index()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信

        $response = $this->actingAs($user)
                         ->json('GET', route('recruitment.index'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }
    public function test_loginuUserIndex()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信

        $response = $this->actingAs($user)
                         ->json('GET', route('recruitment.loginuUserIndex'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }
    public function test_show()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信

        $response = $this->actingAs($user)
                         ->json('GET', route('recruitment.show', [
                            'id' => $Recruitment->id,
                        ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function test_edit()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信

        $response = $this->actingAs($user)
                         ->json('GET', route('recruitment.edit', [
                            'id' => $Recruitment->id,
                        ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }
    public function test_topindex()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // Recruitmentを作成
        $Recruitment = factory(Recruitment::class)->create([
            'user_id' => $user->id,
        ]);

        // actingAsでログイン認証したのちAPI通信

        $response = $this->actingAs($user)
                         ->json('GET', route('recruitment.topindex'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

}
