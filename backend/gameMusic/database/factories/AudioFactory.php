<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Audio;
use Faker\Generator as Faker;

$factory->define(Audio::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'sound_id' => function() {
            return factory(App\SoundMaster::class)->create()->id;
        },
        'title' => $faker->randomLetter,
        'price' => $faker->numberBetween(10,100),
        'audio_file' => $faker->url,
        'sample_audio_file' => $faker->url,
    ];
});
