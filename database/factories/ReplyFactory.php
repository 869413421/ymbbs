<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    $create_date = $faker->dateTimeThisMonth();
    $update_date = $faker->dateTimeThisMonth($create_date);
    return [
        'content' => $faker->sentence(),
        'created_at' => $create_date,
        'updated_at' => $update_date
    ];
});
