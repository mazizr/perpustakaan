<?php

use App\Buku;
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

$factory->define(Buku::class, function (Faker $faker) {
    return [
        'kode_buku' => $faker->numberBetween($min = 0000, $max = 9999),
        'judul' => $faker->word,
        'penulis' => $faker->lastName,
        'penerbit' => $faker->company,
        'tahun_terbit' => $faker->date
    ];
});
