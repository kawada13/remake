<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Recruitment;
use Faker\Generator as Faker;

$factory->define(Recruitment::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'title' => $faker->randomLetter,
        'content' => $faker->randomLetter,
    ];
});
