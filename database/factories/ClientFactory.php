<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client as Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail()
    ];
});
