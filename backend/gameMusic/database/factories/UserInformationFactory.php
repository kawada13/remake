<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserInformation;
use Faker\Generator as Faker;

$factory->define(UserInformation::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'profile_image' => $faker->url,
        'introduce' => $faker->randomLetter,
        'instrument' => $faker->randomLetter,
    ];
});
