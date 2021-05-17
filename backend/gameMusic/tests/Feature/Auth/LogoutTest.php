<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function testLogout()
    {
        // 現在認証済みのユーザーを指定する
        $response = $this->actingAs($this->user)
                         ->json('POST', route('logout'))
                         ->assertJson(['message' => 'ログアウトしました。']);

        $response->assertStatus(200);

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }
}



