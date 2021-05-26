<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TransferAccount;
use Faker\Generator as Faker;

$factory->define(TransferAccount::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'bank_name' => $faker->randomLetter,
        'bank_code' => $faker->numberBetween(10,100),
        'branch_name' => $faker->randomLetter,
        'branch_number' => $faker->numberBetween(10,100),
        'deposit_type' => $faker->randomLetter,
        'account_number' => $faker->numberBetween(10,100),
        'account_holder' => $faker->randomLetter,
    ];
});
