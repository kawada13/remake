<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

// モデル
use App\User;
use App\Audio;
use App\UseMaster;
use App\InstrumentMaster;
use App\SoundMaster;
use App\UnderstaindingMaster;

class AudioTest extends TestCase
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
        $eloquent = app(Audio::class);
        $this->assertEmpty($eloquent->get());
        $entity = factory(Audio::class)->create();
        $this->assertNotEmpty($eloquent->get());
    }

    // リレーションテスト
    public function testAudioBelongsToUser()
    {
        $userEloquent = app(User::class);
        $AudioEloquent = app(Audio::class);

        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // オーディオ作成
        $audio = factory(Audio::class)->create([
            'user_id' => $user->id,
            'sound_id' => $sound->id,
        ]);
        $this->assertNotEmpty($audio->user);
    }



    // データベーステスト

    public function testexhibitedAudios()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('exhibited_audios'));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }

    public function testexhibitedAudioShow()
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

        // actingAsでログイン認証したのちAPI通信
        $response = $this->actingAs($user)
                         ->json('GET', route('exhibited_show', [
                            'id' => $audio->id
                         ]));

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功',]);

    }

}
