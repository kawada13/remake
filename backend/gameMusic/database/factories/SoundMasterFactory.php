<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SoundMaster;
use Faker\Generator as Faker;

$factory->define(SoundMaster::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
