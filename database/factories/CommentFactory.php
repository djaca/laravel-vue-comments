<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'page_id' => 1,
        'body' => $faker->paragraph
    ];
});

$factory->state(App\Comment::class, 'reply', [
    'page_id' => 0,
    'reply_id' => function () {
        return factory(\App\Comment::class)->create()->id;
    },
]);
