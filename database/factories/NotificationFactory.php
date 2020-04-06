<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define('Illuminate\Notifications\DatabaseNotification', function (Faker $faker) {
    return [
        'id' => Str::uuid()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_type' => 'App\User',
        'notifiable_id' => auth()->id() ?: factory('App\User')->create(),
        'data' => ["foo" => "bar"],
    ];
});
