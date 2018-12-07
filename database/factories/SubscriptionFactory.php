<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Subscription::class, function (Faker $faker) {
		$arrayValues = ['active', 'unsubscribed', 'junk', 'bounced', 'unconfirmed'];
        return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'state' => $arrayValues[rand(0,4)],
    ];
});
