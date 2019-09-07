<?php

use App\Anggota;
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

$factory->define(App\Anggota::class, function (Faker $faker) {
    $gender = $faker->randomElements(['Laki - Laki', 'Perempuan'])[0];
    $jurusan = $faker->randomElements(['RPL', 'TKR','TSM'])[0];
    return [
        'kode_anggota' => $faker->numberBetween($min = 0000, $max = 9999),
        'nama' => $faker->name,
        'jk' => $gender,
        'jurusan' => $jurusan,  
        'alamat' => $faker->address
    ];
});
