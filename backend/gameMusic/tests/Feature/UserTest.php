<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

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
}
