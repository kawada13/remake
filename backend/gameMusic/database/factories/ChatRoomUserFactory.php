<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ChatRoomUser;
use Faker\Generator as Faker;

$factory->define(ChatRoomUser::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'chat_room_id' => function() {
            return factory(App\ChatRoom::class)->create()->id;
        },
    ];
});
