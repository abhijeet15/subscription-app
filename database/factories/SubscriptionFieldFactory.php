<?php

use Faker\Generator as Faker;

$factory->define(App\Models\SubscriptionField::class, function (Faker $faker) {

        return [
        'key' => "name",
        'value' => "Abhijeet Bagul"
    ];
});