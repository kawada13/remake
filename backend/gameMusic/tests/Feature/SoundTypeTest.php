<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// モデル
use App\User;
use App\UseMaster;
use App\InstrumentMaster;
use App\SoundMaster;
use App\UnderstaindingMaster;

class SoundTypeTest extends TestCase
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
        // use
        $eloquent = app(UseMaster::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(UseMaster::class)->create();
        $this->assertNotEmpty($eloquent->get());
        
        // instrument
        $eloquent = app(InstrumentMaster::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(InstrumentMaster::class)->create();
        $this->assertNotEmpty($eloquent->get());

        // sound
        $eloquent = app(SoundMaster::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(SoundMaster::class)->create();
        $this->assertNotEmpty($eloquent->get());

        // understanding
        $eloquent = app(UnderstaindingMaster::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(UnderstaindingMaster::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testSound()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('type.sound'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

    public function testUnderstanding()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('type.understanding'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

    public function testUse()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('type.use'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

    public function testInstrument()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('type.instrument'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);
    }

}
