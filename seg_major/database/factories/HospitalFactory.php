<?php

use Faker\Generator as Faker;

$factory->define(App\Hospital::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'hospital_id' =>$faker->numberBetween(10000,20000),
    ];
});
