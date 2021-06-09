<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PurchaseRecord;
use Faker\Generator as Faker;

$factory->define(PurchaseRecord::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'audio_id' => function() {
            return factory(App\Audio::class)->create()->id;
        },
        'stripe_id' => $faker->randomLetter,
        'status' => $faker->numberBetween(10,100),
        'price' => $faker->numberBetween(10,100),
    ];
});
