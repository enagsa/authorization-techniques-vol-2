<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{User,Post};
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
    	'title' => $faker->sentence,
        'user_id' => factory(User::class),
        'teaser' => $faker->sentence,
        'content' => $faker->sentence
    ];
});

$factory->state(Post::class, 'draft', ['status' => 'draft']);
$factory->state(Post::class, 'published', ['status' => 'published']);
