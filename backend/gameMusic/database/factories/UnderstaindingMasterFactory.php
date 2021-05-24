<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UnderstaindingMaster;
use Faker\Generator as Faker;

$factory->define(UnderstaindingMaster::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
