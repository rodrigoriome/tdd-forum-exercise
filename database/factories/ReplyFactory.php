<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});
