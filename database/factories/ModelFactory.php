<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->word,
		'password' => Hash::make(str_random(10)),
		'email' => $faker->email,
		'first_name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'nickname' => '',
		'pos'=> '[46.0898885, 6.5359716]',
		'info' => '[]',
		'active' => 1,
		'hidden' => 0,
		'permissions' => '[]',
    ];
});
