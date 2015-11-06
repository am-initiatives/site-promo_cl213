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
		'password' => Hash::make(str_random(10)),
		'email' => $faker->unique()->email,
		'first_name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'nickname' => $faker->name,
		'pos'=> '['.rand(40,50).",".rand(4,7).']',
		'info' => '[]',
		'active' => 1,
		'hidden' => 0,
		'roles' => '[]',
		'phone' => $faker->phoneNumber
	];
});


$factory->define(App\Models\Transaction::class, function (Faker\Generator $faker) {
	$cid = App\Models\User::orderByRaw("RAND()")->limit(1)->first()->id;
	$did = App\Models\User::where("id","!=",$cid)->orderByRaw("RAND()")->limit(1)->first()->id;
	$state = ["pending","acquited"];
	shuffle($state);

	return [
		'credited_user_id'	=> $cid,
		'debited_user_id' 	=> $did,
		'amount' 			=> rand(10,1000),
		'wording' 			=> join(" ",$faker->words(3)),
		'active' 			=> 1,
		'created_at' 		=> $faker->dateTime,
		'state'				=> $state[0],
		'group_id'			=> Ramsey\Uuid\Uuid::uuid4()->toString(),
	];
});