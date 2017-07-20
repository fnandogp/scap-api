<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'enrollment'     => $faker->numberBetween(1000000000, 9999999999),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Request::class, function (Faker\Generator $faker) {
    return [
        'user_id'             => function () {
            return factory(App\User::class)->create()->id;
        },
        'type'                => array_random(\App\Enums\RequestType::keys()),
        'status'              => array_random(\App\Enums\RequestStatus::keys()),
        'removal_from'        => $faker->dateTimeBetween('now', '+10 days'),
        'removal_to'          => $faker->dateTimeBetween('+30 days', '+100 days'),
        'removal_reason'      => $faker->paragraph,
        'onus'                => array_random(\App\Enums\RequestOnus::keys()),
        'event'               => $faker->sentence,
        'city'                => $faker->city,
        'event_from'          => $faker->dateTimeBetween('+10 days', '+15 days'),
        'event_to'            => $faker->dateTimeBetween('+16 days', '+25 days'),
        'judgment_at'         => $faker->dateTimeBetween('+2 days', '+4 days'),
        'canceled_at'         => $faker->dateTimeBetween('+3 days', '+4 days'),
        'cancellation_reason' => $faker->paragraph,
    ];
});

$factory->define(\App\Mandate::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => function () {
            return factory(\App\User::class)->create();
        },
        'date_from' => $faker->dateTimeBetween('-1 year', '-1 month'),
        'date_to'   => $faker->boolean ? null : $faker->dateTimeBetween('-1 mouth', 'now'),
    ];
});