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
    public function testStore()
    {
        // ユーザー作成
        $user = factory(User::class)->create();

        // サウンドマスター作成
        $sound = factory(SoundMaster::class)->create();

        // ダミーアップロードファイル作成
        $uploadedFile = UploadedFile::fake()->create('audio.mp3',3000);

        // S3ではなくテスト用のストレージを使用する
        // → storage/framework/testing
        Storage::fake('s3');

        // オーディオ作成

        $params = [
            'sound_id' => $sound->id,
            'title' => 'test1',
            'price' => 21,
            'audio_file' => $uploadedFile,
        ];

        $response = $this->actingAs($user)
                         ->json('POST', route('audio.store'), $params);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => '成功']);

        // 作成されたオーディオがちゃんとデータベースに保存されているのか
        $audio = Audio::first();
        $this->assertEquals($params['title'], $audio->title);

        // 作成した音源がテスト用S3にあるのかを確認
        $uploadedFile->move('storage/framework/testing/disks/s3');
        Storage::disk('s3')->assertExists($uploadedFile->getFilename());
    }

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

    public function test_exhibitedAudioDelete()
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

        $response = $this->actingAs($user)
                          ->json('POST', route('exhibited_delete', [
                            'id' => $audio->id,
                        ]));

        $response
            ->assertStatus(200)
            ->assertJson(['isloginUserAudio' => true]);

    }
}
