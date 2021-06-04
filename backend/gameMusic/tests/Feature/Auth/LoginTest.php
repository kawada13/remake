<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;


    /**
     * @test
     */
    public function testLogin()
    {

        // ユーザー作成
        $user = factory(User::class)->create([
            'password'  => bcrypt('laraveltest123')
        ]);


        $response = $this->json('POST', route('login'), [
            'email' => $user->email,
            'password' => 'laraveltest123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'ログイン成功']);

        // 指定したユーザーが認証されているかどうか
        $this->assertAuthenticatedAs($user);
    }


}
