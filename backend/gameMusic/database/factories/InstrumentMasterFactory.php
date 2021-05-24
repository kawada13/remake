<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InstrumentMaster;
use Faker\Generator as Faker;

$factory->define(InstrumentMaster::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
