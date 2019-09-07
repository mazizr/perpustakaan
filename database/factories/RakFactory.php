<?php

use App\Rak;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Rak::class, function (Faker $faker) {
    return [
        'kode_rak' => $faker->numberBetween($min = 0000, $max = 9999),
        'nama_rak' => $faker->word,
        'kode_buku' => factory('App\Buku')->create()->id,
    ];
});
