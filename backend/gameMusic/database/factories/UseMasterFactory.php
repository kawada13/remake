<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UseMaster;
use Faker\Generator as Faker;

$factory->define(UseMaster::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
